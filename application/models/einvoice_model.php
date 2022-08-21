<?php

	class Einvoice_model extends CI_Model {

		protected $_tableSoatve = 'tbl_soatve';
		protected $_tableLoaive = 'tbl_loaive';
		protected $_tableNsd = 'tbl_nsd';
		protected $tableCa = 'tbl_giaoca';

		protected $_tableExtbill = 'tbl_extbill';
		protected $_tableExtbillMsg = 'tbl_extbillmsg';
		protected $_tableThuhoi = 'tbl_thuhoive';

		private $second_db;

		public function __construct() {
			$this->load->database();
			$this->load->model('giaoca_model');
			$this->second_db = $this->load->database('second_db', TRUE);
			parent::__construct();
		}

		public function filter($timestart,$timeend,$time,$type,$ca,$lane,$limit,$length,$draw,$column,$sort) {
			$str_giaocaid = $str_giaocamalane = $str_giaocansd = "";
			$arr_giaocaid = $arr_giaocansd = $arr_giaocamalane = array();
			$sql = "SELECT source_org,source_system,source_trans_id,back_date,price,extbill_matracuu as secure_id, ";
			$sql.= " license_plate,price_type,start_date,end_date,source_systemname,loaive_ten,loaive_mucphi, ";
			$sql.= " soatve_loaiphi,soatve_loaixe,soatve_mave,soatve_id,soatve_malan,thuhoive_soatve as ThuHoi, ";
			$sql.= " extbillmsg_invoiceno,extbillmsg_status, ";
			$sql.= " if ( extbillmsg_status IS NULL OR extbillmsg_status = ".NOT_CREATE_INT.", '".NOT_CREATE_STR."',  ";
			$sql.= " if( extbillmsg_status = ".NOT_SIGN_INT.", '".NOT_SIGN_STR."',";
			$sql.= " if( extbillmsg_status = ".SIGNED_INT.", '".SIGNED_STR."', ";
			$sql.= " if(extbillmsg_status = ".DESTROY_INT.", '".DESTROY_STR."', '".SKIP_STR."')";
			$sql.= " )";
			$sql.= " )";
			$sql.= " )";
			$sql.= " as extbillmsg_statusstr,";
			$sql.= " if(thuhoive_soatve > 0, '".RECALLED_STR."', ";
			$sql.= " if(extbill_matracuu = '' OR extbill_matracuu IS NULL,'".INVALID_LOOKUP_CODE."','".SUCCESS_INVOICE."')";
			$sql.= ")";
			$sql.= " as ThuHoiStr,";
			$sql.= " thuhoive_id, thuhoive_ngaygio FROM (";
			$sql.= " SELECT 'BT' as source_org, ";
			$sql.= " if (soatve_loaiphi mod 100 = ".CPR_VELUOT_INT.",'BT.L', ";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'BT.T', 'BT.Q')";
			$sql.= ") as source_system,";
			$sql.= " soatve_id as source_trans_id, soatve_ngaygio as back_date,soatve_phithu as price,soatve_bienso as license_plate, ";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VELUOT_INT.", 'L',";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'T',";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'Q', 'N')";
			$sql.= ")";
			$sql.= ") as price_type, ";
			$sql.= " NULL as start_date, NULL as end_date,";
			$sql.= " CONCAT('LAN', CAST(`soatve_malan` as CHAR)) as source_systemname,";
			$sql.= " loaive_ten,loaive_mucphi,soatve_loaiphi,soatve_loaixe,soatve_mave,soatve_id,soatve_malan";
			$sql.= " FROM tbl_soatve,tbl_loaive,tbl_nsd WHERE";
			$sql.= " soatve_loaiphi = loaive_loaiphi AND ";
			$sql.= " soatve_loaixe = loaive_loaixe AND";
			$sql.= " soatve_nsd = nsd_id AND nsd_id AND";
			$sql.= " soatve_loaiphi % 100 = ".CPR_VELUOT_INT." ";

			if($type == 0 || $type == 1)
			{
				$listGiaoca = $this->giaoca_model->getGiaoca($ca,$time,$lane,$timestart,$timeend,$type);
				foreach ($listGiaoca as $row) {
					array_push($arr_giaocaid,$row->giaoca_id);
					array_push($arr_giaocansd,$row->giaoca_nsd);
					array_push($arr_giaocamalane,$row->giaoca_malan);
				}
				$str_giaocaid = join(",",$arr_giaocaid);
				$str_giaocansd = join(",",$arr_giaocansd);
				$str_giaocamalane = join(",",$arr_giaocamalane);
				$sql.= " AND soatve_giaoca IN (".$str_giaocaid.")";
				$sql.= " AND soatve_nsd IN (".$str_giaocansd.")";
				$sql.= " AND soatve_malan IN (".$str_giaocamalane.")";
			}
			if($type == 2)
			{
				$sql.= " AND soatve_ngaygio >= '".$timestart."' ";
				$sql.= " AND soatve_ngaygio <= '".$timeend."' ";
			}
			$sql.= ") as table1 ";
			$sql.= " LEFT JOIN tbl_extbill ON soatve_mave = extbill_mabill ";
			$sql.= " LEFT JOIN tbl_extbillmsg ON extbillmsg_source = ".CPR_VELUOT_INT."";
			$sql.= " AND soatve_id =  extbillmsg_sourceid ";
			$sql.= " LEFT JOIN tbl_thuhoive ON thuhoive_soatve = soatve_id ";
			$sql .= " ORDER BY ".$column." ".$sort."";
			$sql .= " LIMIT $limit,$length";

			$query = $this->second_db->query($sql);
	        return $query->result();
		}


		public function countListInvoice($timestart,$timeend,$time,$type,$ca,$lane)
		{
			$str_giaocaid = $str_giaocamalane = $str_giaocansd = "";
			$arr_giaocaid = $arr_giaocansd = $arr_giaocamalane = array();
			$sql = "SELECT count(soatve_id) as count ";
			$sql.= " FROM (";
			$sql.= " SELECT soatve_id,soatve_mave ";
			$sql.= " FROM tbl_soatve,tbl_loaive,tbl_nsd WHERE";
			$sql.= " soatve_loaiphi = loaive_loaiphi AND ";
			$sql.= " soatve_loaixe = loaive_loaixe AND";
			$sql.= " soatve_nsd = nsd_id AND nsd_id AND";
			$sql.= " soatve_loaiphi % 100 = ".CPR_VELUOT_INT." ";

			if($type == 0 || $type == 1)
			{
				$listGiaoca = $this->giaoca_model->getGiaoca($ca,$time,$lane,$timestart,$timeend,$type);
				foreach ($listGiaoca as $row) {
					array_push($arr_giaocaid,$row->giaoca_id);
					array_push($arr_giaocansd,$row->giaoca_nsd);
					array_push($arr_giaocamalane,$row->giaoca_malan);
				}
				$str_giaocaid = join(",",$arr_giaocaid);
				$str_giaocansd = join(",",$arr_giaocansd);
				$str_giaocamalane = join(",",$arr_giaocamalane);
				$sql.= " AND soatve_giaoca IN (".$str_giaocaid.")";
				$sql.= " AND soatve_nsd IN (".$str_giaocansd.")";
				$sql.= " AND soatve_malan IN (".$str_giaocamalane.")";
			}
			if($type == 2)
			{
				$sql.= " AND soatve_ngaygio >= '".$timestart."' ";
				$sql.= " AND soatve_ngaygio <= '".$timeend."' ";
			}
			$sql.= ") as table1 ";
			$sql.= " LEFT JOIN tbl_extbill ON soatve_mave = extbill_mabill ";
			$sql.= " LEFT JOIN tbl_extbillmsg ON extbillmsg_source = ".CPR_VELUOT_INT."";
			$sql.= " AND soatve_id =  extbillmsg_sourceid ";
			$sql.= " LEFT JOIN tbl_thuhoive ON thuhoive_soatve = soatve_id ";
			$query = $this->second_db->query($sql);
	        $result = $query->result();
	        $count = $result[0];
	        $count = $count->count;
	        return $count;
		}

		public function getListInvoice2Export($timestart,$timeend,$time,$type,$ca,$lane)
		{
			$str_giaocaid = $str_giaocamalane = $str_giaocansd = "";
			$arr_giaocaid = $arr_giaocansd = $arr_giaocamalane = array();
			$sql = "SELECT source_org,source_system,source_trans_id,back_date,price,extbill_matracuu as secure_id, ";
			$sql.= " license_plate,price_type,start_date,end_date,source_systemname,loaive_ten,loaive_mucphi, ";
			$sql.= " soatve_loaiphi,soatve_loaixe,soatve_mave,soatve_id,soatve_malan,thuhoive_soatve as ThuHoi, ";
			$sql.= " extbillmsg_invoiceno,extbillmsg_status, ";
			$sql.= " if ( extbillmsg_status IS NULL OR extbillmsg_status = ".NOT_CREATE_INT.", '".NOT_CREATE_STR."',  ";
			$sql.= " if( extbillmsg_status = ".NOT_SIGN_INT.", '".NOT_SIGN_STR."',";
			$sql.= " if( extbillmsg_status = ".SIGNED_INT.", '".SIGNED_STR."', ";
			$sql.= " if(extbillmsg_status = ".DESTROY_INT.", '".DESTROY_STR."', '".SKIP_STR."')";
			$sql.= " )";
			$sql.= " )";
			$sql.= " )";
			$sql.= " as extbillmsg_statusstr,";
			$sql.= " if(thuhoive_soatve > 0, '".RECALLED_STR."', ";
			$sql.= " if(extbill_matracuu = '' OR extbill_matracuu IS NULL,'".INVALID_LOOKUP_CODE."','".SUCCESS_INVOICE."')";
			$sql.= ")";
			$sql.= " as ThuHoiStr,";
			$sql.= " thuhoive_id, thuhoive_ngaygio FROM (";
			$sql.= " SELECT 'BT' as source_org, ";
			$sql.= " if (soatve_loaiphi mod 100 = ".CPR_VELUOT_INT.",'BT.L', ";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'BT.T', 'BT.Q')";
			$sql.= ") as source_system,";
			$sql.= " soatve_id as source_trans_id, soatve_ngaygio as back_date,soatve_phithu as price,soatve_bienso as license_plate, ";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VELUOT_INT.", 'L',";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'T',";
			$sql.= " if(soatve_loaiphi mod 100 = ".CPR_VETHANG_INT.", 'Q', 'N')";
			$sql.= ")";
			$sql.= ") as price_type, ";
			$sql.= " NULL as start_date, NULL as end_date,";
			$sql.= " CONCAT('LAN', CAST(`soatve_malan` as CHAR)) as source_systemname,";
			$sql.= " loaive_ten,loaive_mucphi,soatve_loaiphi,soatve_loaixe,soatve_mave,soatve_id,soatve_malan";
			$sql.= " FROM tbl_soatve,tbl_loaive,tbl_nsd WHERE";
			$sql.= " soatve_loaiphi = loaive_loaiphi AND ";
			$sql.= " soatve_loaixe = loaive_loaixe AND";
			$sql.= " soatve_nsd = nsd_id AND nsd_id AND";
			$sql.= " soatve_loaiphi % 100 = ".CPR_VELUOT_INT." ";

			if($type == 0 || $type == 1)
			{
				$listGiaoca = $this->giaoca_model->getGiaoca($ca,$time,$lane,$timestart,$timeend,$type);
				foreach ($listGiaoca as $row) {
					array_push($arr_giaocaid,$row->giaoca_id);
					array_push($arr_giaocansd,$row->giaoca_nsd);
					array_push($arr_giaocamalane,$row->giaoca_malan);
				}
				$str_giaocaid = join(",",$arr_giaocaid);
				$str_giaocansd = join(",",$arr_giaocansd);
				$str_giaocamalane = join(",",$arr_giaocamalane);
				$sql.= " AND soatve_giaoca IN (".$str_giaocaid.")";
				$sql.= " AND soatve_nsd IN (".$str_giaocansd.")";
				$sql.= " AND soatve_malan IN (".$str_giaocamalane.")";
			}
			if($type == 2)
			{
				$sql.= " AND soatve_ngaygio >= '".$timestart."' ";
				$sql.= " AND soatve_ngaygio <= '".$timeend."' ";
			}
			$sql.= ") as table1 ";
			$sql.= " LEFT JOIN tbl_extbill ON soatve_mave = extbill_mabill ";
			$sql.= " LEFT JOIN tbl_extbillmsg ON extbillmsg_source = ".CPR_VELUOT_INT."";
			$sql.= " AND soatve_id =  extbillmsg_sourceid ";
			$sql.= " LEFT JOIN tbl_thuhoive ON thuhoive_soatve = soatve_id ";

			$query = $this->second_db->query($sql);
	        return $query->result();
		}
	}