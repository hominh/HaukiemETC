<?php
	class Cartype_model extends CI_Model {
		protected $_table = 'tbl_loaixe';

		public function __construct() {
			$this->load->database();
			parent::__construct();
		}

		public function getList() {
			$this->db->cache_on();
			$query = $this->db->get($this->_table);
			return $query->result();
		}
	}
?>