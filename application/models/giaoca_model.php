<?php
	
	class Giaoca_model extends CI_Model {
		protected $_tableGiaoca = 'tbl_giaoca';
		protected $_tableLane = 'tbl_lanxe';

		private $second_db;

		public function __construct() {
			$this->load->database();
			$this->second_db = $this->load->database('second_db', TRUE);
			parent::__construct();
		}

		public function getGiaoca($ca,$date,$lane,$fromTime,$toTime,$type)
		{
			$sql = "SELECT giaoca_id,giaoca_malan,giaoca_batdau,giaoca_ketthuc,giaoca_nsd,lanxe_loailan ";
			$sql.= " FROM ".$this->_tableGiaoca." ";
			$sql.= " LEFT JOIN ".$this->_tableLane." ON giaoca_malan = lanxe_id ";
			if($type == 0)
			{
				$sql.= " WHERE giaoca_cangay = '".$date."' AND giaoca_ca = ".$ca."";
				if($lane != 0)
					$sql.= " AND giaoca_malan = ".$lane."";
			}
			if($type == 1)
			{
				$sql.= " WHERE giaoca_cangay = '".$date."'";
				if($lane != 0)
					$sql.= " AND giaoca_malan = ".$lane."";
			}
			$query = $this->second_db->query($sql);
	        return $query->result();
		}
	}