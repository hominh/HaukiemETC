<?php
	class Employee_model extends CI_Model {
		protected $_table = 'tbl_nsd';

		public function __construct() {
			$this->load->database();
			parent::__construct();
		}

		public function findEmployeeByRole($role)
		{
			$sql = "SELECT * FROM ".$this->_table." WHERE nsd_quyen & ".$role."";
			$query = $this->db->query($sql);
	        return $query->result();
		}

		public function login($username, $password)
		{
			$password = md5($password);
			$this->db->select('nsd_id, nsd_ten, nsd_matkhau,nsd_quyen,nsd_nhom');
			$this->db->from($this->_table);
			$this->db->where('nsd_mavach', $username);
			$this->db->where('nsd_matkhau', $password);
			$this->db->limit(1);
			$query = $this->db->get();
            if($query->num_rows() == 1)
                return $query->result();
            else
                return false;
		}
	}
?>