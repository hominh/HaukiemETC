<?php

	class Report_model extends CI_Model {

		protected $_tableSoatve = 'tbl_soatve';
		protected $_tableTransaction = 'tbl_vetctransactionafterchange';
		protected $_tableLoaixe = 'tbl_loaixe';
		protected $_tableLoaive = 'tbl_loaive';
		private $second_db;

		public function __construct() {
			$this->load->database();
			$this->load->model('param_model');
			$this->second_db = $this->load->database('second_db', TRUE);
			parent::__construct();
		}


	}
