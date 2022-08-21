<?php
	class Vehicle_model extends CI_Model {
		protected $_table = 'tbl_xe';

		public function __construct() {
			$this->load->database();
			parent::__construct();
		}

		public function getList() {
			$this->db->cache_on();
			$query = $this->db->get($this->_table);
			return $query->result();
		}

		public function getVehicleByPlate($plate)
		{
			$sql = "SELECT xe_id,xe_bienso,xe_loaixe,xe_ngaynhap,xe_ghichu,xe_canhbao,nsd_ten ";
			$sql.= " FROM tbl_xe ";
			$sql.= " LEFT JOIN tbl_nsd ON xe_nsd = nsd_id ";
			$sql.= " WHERE xe_bienso = '".$plate."' LIMIT 1";
			$query = $this->db->query($sql);
	        return $query->result();
		}

		public function update($data)
		{
			$this->db->where("xe_bienso", $data["xe_bienso"]);
			$query = $this->db->get($this->_table);
    		if ($query->num_rows() > 0)
    		{
    			$this->db->where("xe_bienso", $data["xe_bienso"]);
    			$this->db->update($this->_table, $data);
    		}
    		else
    			$this->db->insert($this->_table,$data);
    		return ($this->db->affected_rows() != 1) ? false : true;
			//$this->db->where("xe_bienso", $vetctransaction_ticketid);
		}
	}
?>