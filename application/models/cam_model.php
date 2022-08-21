<?php
	class Cam_model extends CI_Model {
		protected $_table = 'tbl_cam';
		private $otherdb;

		public function __construct() {
			$this->load->database();
			$this->load->library('base');
			$this->otherdb = $this->load->database('otherdb', TRUE);
			parent::__construct();

		}

		public function getList() {
			$this->otherdb->cache_on();
			$sql = "SELECT cam_id,CONCAT(cam_sohieu,'_',cam_ten) as cam_ten FROM ".$this->_table."";
			$query = $this->otherdb->query($sql);
			return $query->result();
		}
	}