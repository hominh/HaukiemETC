<?php
	class Video_model extends CI_Model {
		protected $_table = 'tbl_video';
		private $otherdb;

		public function __construct() {
			$this->load->database();
			$this->load->library('base');
			$this->otherdb = $this->load->database('otherdb', TRUE);
			parent::__construct();

		}

		public function getListByTime($time,$limit,$length,$draw,$column,$sort) {
			$from_time = $this->base->getDateTimeBegin($time);
			$to_time = $this->base->getDateTimeEnd($time);
			$sql = "SELECT video_id,video_url,video_thoigian,video_dodai,CONCAT(cam_sohieu,'_',cam_ten) as cam_ten FROM ".$this->_table."";
			$sql.= " LEFT JOIN tbl_cam ON video_cam = cam_id";
			$sql.= " WHERE video_trangthai > 0 AND video_trangthai < 15";
			$sql.= " AND video_thoigian >= '".$from_time."' AND video_thoigian <= '".$to_time."'";
			$sql .= " ORDER BY ".$column." ".$sort."";
	        $sql .= " LIMIT $limit,$length";
			$query = $this->otherdb->query($sql);
	        return $query->result();
		}

		public function countListByTime($time) {
			$from_time = $this->base->getDateTimeBegin($time);
			$to_time = $this->base->getDateTimeEnd($time);

			$otherdb = $this->load->database('otherdb', TRUE);
			$sql = "SELECT count(video_id) as count FROM ".$this->_table."";
			$sql.= " LEFT JOIN tbl_cam ON video_cam = cam_id";
			$sql.= " WHERE video_trangthai > 0 AND video_trangthai < 15";
			$sql.= " AND video_thoigian >= '".$from_time."' AND video_thoigian <= '".$to_time."'";
			$query = $this->otherdb->query($sql);
	        $result = $query->result();
	        $count = $result[0];
	        $count = $count->count;
	        return $count;
		}

		public function filter($fromtime,$totime,$camera,$limit,$length,$draw,$column,$sort)
		{
			$sql = "SELECT video_id,video_url,video_thoigian,video_dodai,CONCAT(cam_sohieu,'_',cam_ten) as cam_ten FROM ".$this->_table."";
			$sql.= " LEFT JOIN tbl_cam ON video_cam = cam_id";
			$sql.= " WHERE video_trangthai > 0 AND video_trangthai < 15";
			$sql.= " AND video_thoigian >= '".$fromtime."' AND video_thoigian <= '".$totime."'";
			if($camera > 0)
				$sql.= " AND cam_id = ".$camera."";
			$sql .= " ORDER BY ".$column." ".$sort."";
	        $sql .= " LIMIT $limit,$length";
			$query = $this->otherdb->query($sql);
	        return $query->result();
		}

		public function countList($fromtime,$totime,$camera)
		{
			$sql = "SELECT count(video_id) as count FROM ".$this->_table."";
			$sql.= " LEFT JOIN tbl_cam ON video_cam = cam_id";
			$sql.= " WHERE video_trangthai > 0 AND video_trangthai < 15";
			$sql.= " AND video_thoigian >= '".$fromtime."' AND video_thoigian <= '".$totime."'";
			if($camera > 0)
				$sql.= " AND cam_id = ".$camera."";
			$query = $this->otherdb->query($sql);
	        $result = $query->result();
	        $count = $result[0];
	        $count = $count->count;
	        return $count;
		}

	}
?>