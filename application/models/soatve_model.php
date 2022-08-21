<?php
	
	class Soatve_model extends CI_Model {

		protected $_tableSoatve = 'tbl_soatve';
		protected $barcodeMPC;
		protected $barcodeMPDC;

		public function __construct() {
			$this->load->database();
			$this->load->model('param_model');
			$this->barcodeMPC = $this->param_model->getParamByName('ID_MienPhiCo');
			$this->barcodeMPDC = $this->param_model->getParamByName('ID_TheoDoanCo');
			parent::__construct();
		}

		public function getListSoatve($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc,$limit,$length,$draw,$column,$sort)
		{
			//$this->db->cache_on();
			$sql = "SELECT soatve_ngaygio as ngaygio, a.soatve_malan as lanxe, ";
	        $sql.= " a.soatve_bienso as bienso,p.vetctransaction_plate as plateetag,a.soatve_mave as mave, ";
	        $sql.= " case p.vetctransaction_committype when";
	        $sql.= " ".TRANSACTION_TYPE_PENDING_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_PENDING_STR."' WHEN";
	        $sql.= " ".TRANSACTION_TYPE_COMMIT_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_COMMIT_STR."' WHEN";
	        $sql.= " ".TRANSACTION_TYPE_ROOLBACK_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_ROOLBACK_STR."' ";
	        $sql.= " END as vetctransaction_committype,";
	        $sql.= "CONCAT_WS(' ',";
	        $sql.= " if(a.soatve_loaiphi mod 100 in(";
	        $sql.= " ".VETC_VELUOT_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_VETHANG_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_VEQUY_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_WHITELIST_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_OFFLINE_CONVERT_2_CADPRO."";
	        $sql.= "), 'ETC',";
	        $sql.= " IF(a.soatve_loaiphi MOD 100=".VAOLAN_KIN_INT.",if(vetctransaction_committype is null,'MTC','ETC'),'MTC')),";
	        $sql.= " case soatve_loaiphi mod 100 ";
	        $sql.= " WHEN ".CPR_VELUOT_INT." THEN '".CPR_VELUOT_STR."'";
	        $sql.= " WHEN ".VETC_VELUOT_CONVERT_2_CADPRO." THEN '".CPR_VELUOT_STR."'";
	        $sql.= " WHEN ".CPR_VETHANG_INT." THEN '".CPR_VETHANG_STR."'";
	        $sql.= " WHEN ".VETC_VETHANG_CONVERT_2_CADPRO." THEN '".CPR_VETHANG_STR."'";
	        $sql.= " WHEN ".CPR_VEQUY_INT." THEN '".CPR_VEQUY_STR."'";
	        $sql.= " WHEN ".VETC_VEQUY_CONVERT_2_CADPRO." THEN '".CPR_VEQUY_STR."'";
	        $sql.= " WHEN ".VAOLAN_KIN_INT." THEN '".VAOLAN_KIN_STR."'";
	        $sql.= " WHEN ".CPR_LUOT_VE_GIAY_INT." THEN '".CPR_LUOT_VE_GIAY_STR."'";
	        $sql.= " WHEN ".CPR_QUOC_LO_LUOT_INT." THEN '".CPR_QUOC_LO_LUOT_STR."'";
	        $sql.= " WHEN ".CPR_TOAN_QUOC_INT." THEN '".CPR_TOAN_QUOC_STR."'";
	        $sql.= " WHEN ".CPR_DOANXE_INT." THEN '".CPR_DOANXE_STR."'";
	        $sql.= " WHEN ".VETC_WHITELIST_CONVERT_2_CADPRO." THEN '".TRANSACTION_TYPE_WHITELIST_STR."'";
	        $sql.= " WHEN ".VETC_OFFLINE_CONVERT_2_CADPRO." THEN '".TRANSACTION_TYPE_OFFLINE_STR."'";
	        $sql.= " WHEN ".CPR_VUOTTRAM_INT." THEN '".CPR_VUOTTRAM_STR."'";
	        $sql.= " END, ";
	        $sql.= " Concat(' loại ', cast(a.soatve_loaixe as char), concat(tram_ten,' - ','1111'))) as loaive, ";
	        $sql.= " IF(a.soatve_loaixe = 0,' ',a.soatve_loaixe) as loaixe, a.soatve_mathe as mathe,a.soatve_phithu as phithu, ";
	        $sql.= " h.loailoi_ten,a.soatve_loaiphi, a.soatve_id as idsoatve,";
	        //$sql.= " a.soatve_id as idsoatve, p.vetctransaction_image1 as image1,p.vetctransaction_image2 as image2, ";
	        //$sql.= " a.soatve_id as idsoatve, ";
	        $sql.= " p.vetctransaction_id as vetctransaction_id,";
	        //$sql.= " IF(k.soatvechecking_mienphiid,'Xe miễn phí','') as xemienphi,";
	        //$sql.= " IF(k.soatvechecking_mienphiid,'Xe miễn phí','') as xemienphi,";
	        $sql.= " b.nsd_ten as soatvevien,IFNULL(p.vetctransaction_tagid,a.soatve_mathe) as tagid, ";
	        $sql.= " if(e.thuhoive_id >0,'".CPR_THUHOI_STR."',";
	        $sql.= " if(x.banboxung_id >0,'".CPR_BANBOXUNG_STR."',";
	        $sql.= " if(z.banmoi_id >0 ,'".CPR_BANMOI_STR."',''))) as trangthaive,CONCAT(f.lanxe_urllanxe,a.soatve_maanh) as anhlanxe, CONCAT(f.lanxe_urlbienso,a.soatve_maanh) as anhbienso ";
	        $sql.= " FROM tbl_soatve a";
	        $sql.= " left join tbl_nsd b on a.soatve_nsd = b.nsd_id";
	        $sql.= " left join tbl_nsd c on a.soatve_giamsat = c.nsd_id";
	        $sql.= " left join tbl_loaive d on (a.soatve_loaiphi = d.loaive_loaiphi AND a.soatve_loaixe = d.loaive_loaixe)";
	        $sql.= " left join tbl_loailoi h on a.soatve_maloi= h.loailoi_id";
	        //$sql.= " left join tbl_soatvechecking k on a.soatve_id= k.soatvechecking_soatveid";
	        $sql.= " LEFT JOIN tbl_tram ON (a.soatve_loaiphi DIV 100 = tram_id)";
	        $sql.= " LEFT JOIN tbl_thuhoive e on a.soatve_id= e.thuhoive_soatve";
	        $sql.= " LEFT JOIN tbl_banboxung x on a.soatve_id = x.banboxung_soatve ";
	        $sql.= " LEFT JOIN tbl_banmoi z on a.soatve_id = z.banmoi_soatve";
	        $sql.= " LEFT JOIN tbl_lanxe f on a.soatve_malan = f.lanxe_id ";
	        $sql.= " LEFT JOIN tbl_vetctransactionafterchange p on a.soatve_mave = p.vetctransaction_ticketid AND soatve_malan = p.vetctransaction_lane  ";
	        $sql.= " WHERE a.soatve_ngaygio >= '".$timestart."' AND a.soatve_ngaygio <= '".$timeend."'";
        	if(!empty($plate)) $sql .=" and a.soatve_bienso = '".$plate."'";
	        if(!empty($barcode)) $sql .=" and a.soatve_mave = '".$barcode."'";
	        if ($employee != 0) $sql .=" and a.soatve_nsd = $employee";
	        if ($lane != 0) $sql .=" and a.soatve_malan = $lane";
	        if($cartype != 0) $sql .=" and a.soatve_loaixe = $cartype";
	        if ($platetype != "A") $sql .=" and p.vetctransaction_plate LIKE '%".$platetype."'";
	        if ($transactiontype != 3) $sql .=" and p.vetctransaction_committype = $transactiontype";
	        if(strlen($tickettype) > 0) $sql .=" and a.soatve_loaiphi mod 100 in ($tickettype)";
	        if($freec != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = '".$this->barcodeMPC."'";
			if($freec != 0 && empty($tickettype)) $sql.=" AND a.soatve_mave = '".$this->barcodeMPC."'";
	        if($freedc != 0 && empty($tickettype)) $sql .=" AND a.soatve_mave = '".$this->barcodeMPDC."'";
			if($freedc != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = '".$this->barcodeMPDC."'";


	        if($isMoney != 3)
	        {
	            if($isMoney == 0) $sql .=" and a.soatve_phithu = 0";
	            if($isMoney == 1) $sql .=" and a.soatve_phithu > 0";
	        }
	        if($tickettypevetc != 0)
	        {
	            if($tickettypevetc == 1) $sql .=" and p.vetctransaction_pricetickettype = 1";
	            if($tickettypevetc == 2) $sql .=" and p.vetctransaction_pricetickettype = 5";
	        }
	        $sql .= " ORDER BY ".$column." ".$sort."";
	        $sql .= " LIMIT $limit,$length";
	       
	        $query = $this->db->query($sql);
	        return $query->result();
		}

		public function getCountListSoatve($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc)
		{
			//$this->db->cache_on();
			$sql = "SELECT COUNT(soatve_id) as count ";
	        $sql.= " FROM tbl_soatve a";
	        $sql.= " left join tbl_nsd b on a.soatve_nsd = b.nsd_id";
	        $sql.= " left join tbl_nsd c on a.soatve_giamsat = c.nsd_id";
	        $sql.= " left join tbl_loaive d on (a.soatve_loaiphi = d.loaive_loaiphi AND a.soatve_loaixe = d.loaive_loaixe)";
	        $sql.= " left join tbl_loailoi h on a.soatve_maloi= h.loailoi_id";
	        //$sql.= " left join tbl_soatvechecking k on a.soatve_id= k.soatvechecking_soatveid";
	        $sql.= " LEFT JOIN tbl_tram ON (a.soatve_loaiphi DIV 100 = tram_id)";
	        $sql.= " left join tbl_thuhoive e on a.soatve_id= e.thuhoive_soatve";
	        $sql.= " left join tbl_banboxung x on a.soatve_id = x.banboxung_soatve ";
	        $sql.= " left join tbl_banmoi z on a.soatve_id = z.banmoi_soatve";
	        $sql.= " LEFT JOIN tbl_vetctransactionafterchange p on a.soatve_mave = p.vetctransaction_ticketid AND soatve_malan = p.vetctransaction_lane  ";
	        $sql.= " WHERE a.soatve_ngaygio >= '".$timestart."' AND a.soatve_ngaygio <= '".$timeend."'";
        	if(!empty($plate)) $sql .=" and a.soatve_bienso = '".$plate."'";
	        if(!empty($barcode)) $sql .=" and a.soatve_mave = '".$barcode."'";
	        if ($employee != 0) $sql .=" and a.soatve_nsd = $employee";
	        if ($lane != 0) $sql .=" and a.soatve_malan = $lane";
	        if($cartype != 0) $sql .=" and a.soatve_loaixe = $cartype";
	        if ($platetype != "A") $sql .=" and p.vetctransaction_plate LIKE '%".$platetype."'";
	        if ($transactiontype != 3) $sql .=" and p.vetctransaction_committype = $transactiontype";
	        if(!empty($tickettype)) $sql .=" and a.soatve_loaiphi mod 100 in ($tickettype)";
	        if($freec != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = 'BTBB7777'";
			if($freec != 0 && empty($tickettype)) $sql.=" AND a.soatve_mave = 'BTBB7777'";
	        if($freedc != 0 && empty($tickettype)) $sql .=" AND a.soatve_mave = 'BTBB8888'";
			if($freedc != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = 'BTBB8888'";


	        if($isMoney != 3)
	        {
	            if($isMoney == 0) $sql .=" and a.soatve_phithu = 0";
	            if($isMoney == 1) $sql .=" and a.soatve_phithu > 0";
	        }
	        if($tickettypevetc != 0)
	        {
	            if($tickettypevetc == 1) $sql .=" and p.vetctransaction_pricetickettype = 1";
	            if($tickettypevetc == 2) $sql .=" and p.vetctransaction_pricetickettype = 5";
	        }
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        $count = $result[0];
	        $count = $count->count;
	        return $count;
		}

		public function updatePlate($data_update,$soatve_id)
		{
			$this->db->where('soatve_id', $soatve_id);
			$this->db->update($this->_tableSoatve, $data_update);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function getListByPlate($plate)
		{
			$this->db->select('soatve_id,soatve_ngaygio,soatve_bienso,soatve_malan,soatve_loaixe,soatve_phithu,soatve_mave');
			$this->db->from($this->_tableSoatve);
			$this->db->where('soatve_bienso',$plate);
			$this->db->limit(5);
			$query = $this->db->get();
	        return $query->result();
		}

		public function getListSoatve2ExportExcel($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc)
		{
			//$this->db->cache_on();
			$sql = "SELECT soatve_ngaygio as ngaygio, a.soatve_malan as lanxe, ";
	        $sql.= " a.soatve_bienso as bienso,p.vetctransaction_plate as plateetag,a.soatve_mave as mave, ";
	        $sql.= " case p.vetctransaction_committype when";
	        $sql.= " ".TRANSACTION_TYPE_PENDING_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_PENDING_STR."' WHEN";
	        $sql.= " ".TRANSACTION_TYPE_COMMIT_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_COMMIT_STR."' WHEN";
	        $sql.= " ".TRANSACTION_TYPE_ROOLBACK_INT." THEN";
	        $sql.= " '".TRANSACTION_TYPE_ROOLBACK_STR."' ";
	        $sql.= " END as vetctransaction_committype,";
	        $sql.= "CONCAT_WS(' ',";
	        $sql.= " if(a.soatve_loaiphi mod 100 in(";
	        $sql.= " ".VETC_VELUOT_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_VETHANG_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_VEQUY_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_WHITELIST_CONVERT_2_CADPRO.",";
	        $sql.= " ".VETC_OFFLINE_CONVERT_2_CADPRO."";
	        $sql.= "), 'ETC',";
	        $sql.= " IF(a.soatve_loaiphi MOD 100=".VAOLAN_KIN_INT.",if(vetctransaction_committype is null,'MTC','ETC'),'MTC')),";
	        $sql.= " case soatve_loaiphi mod 100 ";
	        $sql.= " WHEN ".CPR_VELUOT_INT." THEN '".CPR_VELUOT_STR."'";
	        $sql.= " WHEN ".VETC_VELUOT_CONVERT_2_CADPRO." THEN '".CPR_VELUOT_STR."'";
	        $sql.= " WHEN ".CPR_VETHANG_INT." THEN '".CPR_VETHANG_STR."'";
	        $sql.= " WHEN ".VETC_VETHANG_CONVERT_2_CADPRO." THEN '".CPR_VETHANG_STR."'";
	        $sql.= " WHEN ".CPR_VEQUY_INT." THEN '".CPR_VEQUY_STR."'";
	        $sql.= " WHEN ".VETC_VEQUY_CONVERT_2_CADPRO." THEN '".CPR_VEQUY_STR."'";
	        $sql.= " WHEN ".VAOLAN_KIN_INT." THEN '".VAOLAN_KIN_STR."'";
	        $sql.= " WHEN ".CPR_LUOT_VE_GIAY_INT." THEN '".CPR_LUOT_VE_GIAY_STR."'";
	        $sql.= " WHEN ".CPR_QUOC_LO_LUOT_INT." THEN '".CPR_QUOC_LO_LUOT_STR."'";
	        $sql.= " WHEN ".CPR_TOAN_QUOC_INT." THEN '".CPR_TOAN_QUOC_STR."'";
	        $sql.= " WHEN ".CPR_DOANXE_INT." THEN '".CPR_DOANXE_STR."'";
	        $sql.= " WHEN ".VETC_WHITELIST_CONVERT_2_CADPRO." THEN '".TRANSACTION_TYPE_WHITELIST_STR."'";
	        $sql.= " WHEN ".VETC_OFFLINE_CONVERT_2_CADPRO." THEN '".TRANSACTION_TYPE_OFFLINE_STR."'";
	        $sql.= " WHEN ".CPR_VUOTTRAM_INT." THEN '".CPR_VUOTTRAM_STR."'";
	        $sql.= " END, ";
	        $sql.= " Concat(' loại ', cast(a.soatve_loaixe as char), concat(tram_ten,' - ','1111'))) as loaive, ";
	        $sql.= " IF(a.soatve_loaixe = 0,' ',a.soatve_loaixe) as loaixe, a.soatve_mathe as mathe,a.soatve_phithu as phithu, ";
	        $sql.= " h.loailoi_ten,a.soatve_loaiphi, a.soatve_id as idsoatve,";
	        //$sql.= " a.soatve_id as idsoatve, p.vetctransaction_image1 as image1,p.vetctransaction_image2 as image2, ";
	        //$sql.= " a.soatve_id as idsoatve, ";
	        $sql.= " p.vetctransaction_id as vetctransaction_id,";
	        //$sql.= " IF(k.soatvechecking_mienphiid,'Xe miễn phí','') as xemienphi,";
	        //$sql.= " IF(k.soatvechecking_mienphiid,'Xe miễn phí','') as xemienphi,";
	        $sql.= " b.nsd_ten as soatvevien,IFNULL(p.vetctransaction_tagid,a.soatve_mathe) as tagid, ";
	        $sql.= " if(e.thuhoive_id >0,'".CPR_THUHOI_STR."',";
	        $sql.= " if(x.banboxung_id >0,'".CPR_BANBOXUNG_STR."',";
	        $sql.= " if(z.banmoi_id >0 ,'".CPR_BANMOI_STR."',''))) as trangthaive,CONCAT(f.lanxe_urllanxe,a.soatve_maanh) as anhlanxe, CONCAT(f.lanxe_urlbienso,a.soatve_maanh) as anhbienso ";
	        $sql.= " ,IF(a.soatve_bienso <> IF( RIGHT( vetctransaction_plate, 1 ) = 'T' OR RIGHT( vetctransaction_plate, 1 ) = 'V' OR RIGHT( vetctransaction_plate, 1 ) = 'X', SUBSTRING( vetctransaction_plate, 1, CHAR_LENGTH( vetctransaction_plate ) -1 ) , a.soatve_bienso ),'CHECK','OK') as CHECKED";
	        $sql.= " FROM tbl_soatve a";
	        $sql.= " left join tbl_nsd b on a.soatve_nsd = b.nsd_id";
	        $sql.= " left join tbl_nsd c on a.soatve_giamsat = c.nsd_id";
	        $sql.= " left join tbl_loaive d on (a.soatve_loaiphi = d.loaive_loaiphi AND a.soatve_loaixe = d.loaive_loaixe)";
	        $sql.= " left join tbl_loailoi h on a.soatve_maloi= h.loailoi_id";
	        //$sql.= " left join tbl_soatvechecking k on a.soatve_id= k.soatvechecking_soatveid";
	        $sql.= " LEFT JOIN tbl_tram ON (a.soatve_loaiphi DIV 100 = tram_id)";
	        $sql.= " LEFT JOIN tbl_thuhoive e on a.soatve_id= e.thuhoive_soatve";
	        $sql.= " LEFT JOIN tbl_banboxung x on a.soatve_id = x.banboxung_soatve ";
	        $sql.= " LEFT JOIN tbl_banmoi z on a.soatve_id = z.banmoi_soatve";
	        $sql.= " LEFT JOIN tbl_lanxe f on a.soatve_malan = f.lanxe_id ";
	        $sql.= " LEFT JOIN tbl_vetctransactionafterchange p on a.soatve_mave = p.vetctransaction_ticketid AND soatve_malan = p.vetctransaction_lane  ";
	        $sql.= " WHERE a.soatve_ngaygio >= '".$timestart."' AND a.soatve_ngaygio <= '".$timeend."'";
        	if(!empty($plate)) $sql .=" and a.soatve_bienso = '".$plate."'";
	        if(!empty($barcode)) $sql .=" and a.soatve_mave = '".$barcode."'";
	        if ($employee != 0) $sql .=" and a.soatve_nsd = $employee";
	        if ($lane != 0) $sql .=" and a.soatve_malan = $lane";
	        if($cartype != 0) $sql .=" and a.soatve_loaixe = $cartype";
	        if ($platetype != "A") $sql .=" and p.vetctransaction_plate LIKE '%".$platetype."'";
	        if ($transactiontype != 3) $sql .=" and p.vetctransaction_committype = $transactiontype";
	        if(strlen($tickettype) > 0) $sql .=" and a.soatve_loaiphi mod 100 in ($tickettype)";
	        if($freec != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = '".$this->barcodeMPC."'";
			if($freec != 0 && empty($tickettype)) $sql.=" AND a.soatve_mave = '".$this->barcodeMPC."'";
	        if($freedc != 0 && empty($tickettype)) $sql .=" AND a.soatve_mave = '".$this->barcodeMPDC."'";
			if($freedc != 0 && !empty($tickettype)) $sql .=" or a.soatve_mave = '".$this->barcodeMPDC."'";


	        if($isMoney != 3)
	        {
	            if($isMoney == 0) $sql .=" and a.soatve_phithu = 0";
	            if($isMoney == 1) $sql .=" and a.soatve_phithu > 0";
	        }
	        if($tickettypevetc != 0)
	        {
	            if($tickettypevetc == 1) $sql .=" and p.vetctransaction_pricetickettype = 1";
	            if($tickettypevetc == 2) $sql .=" and p.vetctransaction_pricetickettype = 5";
	        }
	        $query = $this->db->query($sql);
	        return $query->result();
		}
	}
?>