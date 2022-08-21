<?php
	class Param_model extends CI_Model {

		protected $_table = 'tbl_thamso';
		private $second_db;

		public function __construct() {
			$this->load->database();
			$this->second_db = $this->load->database('second_db', TRUE);
			parent::__construct();
		}

		public function getList() {
			$this->second_db->cache_on();
			$query = $this->second_db->get($this->_table);
			return $query->result();
		}

		public function getParamByName($name)
		{
			$sql = "SELECT thamso_giatri FROM ".$this->_table." WHERE thamso_ten = '".$name."' LIMIT 1";
			$query = $this->second_db->query($sql);
			$result = $query->result();
	        $paramValue = $result[0];
	        $paramValue = $paramValue->thamso_giatri;
	        return $paramValue;
		}
	}
?>