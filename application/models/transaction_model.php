<?php
	class Transaction_model extends CI_Model {
		protected $_table = 'tbl_vetctransactionafterchange';
		protected $_table_tmp = 'tbl_vetctransactiontmp';

		public function __construct() {
			$this->load->database();
			parent::__construct();
		}

		public function changeCommitType($data_update, $vetctransaction_ticketid){
			$this->db->where("vetctransaction_ticketid", $vetctransaction_ticketid);
			$this->db->update($this->_table, $data_update);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function lockTransaction($vetctransaction_ticketid)
		{
			$this->db->where('vetctransaction_ticketid', $vetctransaction_ticketid);
			$this->db->delete($this->_table);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function insertTmp($data)
		{
			$this->db->insert($this->_table_tmp,$data);
    		return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function truncateTransactiontmp()
		{
			$result = $this->db->truncate($this->_table_tmp);
			return $result;
		}

		public function getMinTimeforCompareTransaction()
		{
			$sql = "SELECT MIN(vetctransaction_time) as timestart FROM ".$this->_table_tmp."";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function getMaxTimeforCompareTransaction()
		{
			$sql = "SELECT MAX(vetctransaction_time) as timeend FROM ".$this->_table_tmp."";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function compareVETCGetTransactionNotFoundInCadpro($starttime,$endtime)
		{
			$sql = "SELECT vetctransaction_id, vetctransaction_ticketid, vetctransaction_tagid, vetctransaction_time, vetctransaction_plate,vetctransaction_lane, vetctransaction_price ";
			$sql.= " FROM ".$this->_table_tmp." ";
			$sql.= " WHERE vetctransaction_time >= '".$starttime."' AND vetctransaction_time <= '".$endtime."'";
			$sql.= " AND vetctransaction_ticketid NOT IN (SELECT vetctransaction_ticketid FROM ".$this->_table." WHERE vetctransaction_time >= '".$starttime."' AND vetctransaction_time <= '".$endtime."' ";
			$sql.= " AND vetctransaction_committype = 1 AND vetctransaction_checkinstatus = 0";
			$sql.= " )";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function compareVETCGetTransactionNotFoundInVETC($starttime,$endtime)
		{
			$sql = "SELECT vetctransaction_id, vetctransaction_ticketid, vetctransaction_tagid, vetctransaction_time, vetctransaction_plate,vetctransaction_lane, vetctransaction_price ";
			$sql.= " FROM ".$this->_table." ";
			$sql.= " WHERE vetctransaction_time >= '".$starttime."' AND vetctransaction_time <= '".$endtime."'";
			$sql.= " AND vetctransaction_ticketid NOT IN (SELECT vetctransaction_ticketid FROM ".$this->_table_tmp." WHERE vetctransaction_time >= '".$starttime."' AND vetctransaction_time <= '".$endtime."' ";
			$sql.= " AND vetctransaction_committype = 1 AND vetctransaction_checkinstatus = 0";
			$sql.= " )";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function compareVETCGetTransactionInvalid($starttime,$endtime)
		{
			$sql = "SELECT a.vetctransaction_id, a.vetctransaction_ticketid, a.vetctransaction_tagid, a.vetctransaction_time, a.vetctransaction_plate AS plateCPR, b.vetctransaction_plate AS plateVETC, a.vetctransaction_lane, a.vetctransaction_price AS priceCPR, b.vetctransaction_price AS priceVETC ";
			$sql.= " FROM ".$this->_table." a, ".$this->_table_tmp." b ";
			$sql.= " WHERE a.vetctransaction_time >= '".$starttime."' AND a.vetctransaction_time <= '".$endtime."'";
			$sql.= " AND b.vetctransaction_time >= '".$starttime."' AND b.vetctransaction_time <= '".$endtime."'";
			$sql.= " AND a.vetctransaction_ticketid = b.vetctransaction_ticketid ";
			$sql.= " AND a.vetctransaction_price != b.vetctransaction_price";
			$query = $this->db->query($sql);
			return $query->result();
		}
	}
?>