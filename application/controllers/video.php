<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends My_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->model('video_model');
        $this->load->library('session');
    }

    public function getListByTime()
    {
    	if($this->login())
    	{
    		$data = array();
    		$columns = array("video_id","cam_ten","video_thoigian");
    		$video_thoigian = $this->input->post("video_thoigian");
    		$limit = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $order = $this->input->post('order');
	        $order = $order[0];
	        $column = $order['column'];
	        $column = $columns[$column];
	        $sort = $order['dir'];
    		$listVideo = $this->video_model->getListByTime($video_thoigian,$limit,$length,$draw,$column,$sort);
    		foreach($listVideo as $row)
	        {
	        	$sub_array = array();
	            $sub_array[] = $row->video_id;
	            $sub_array[] = $row->cam_ten;
	           	$sub_array[] = $row->video_thoigian;
	           	$sub_array[] = $row->video_url;
	            $data[] = $sub_array;
	        }
	        $output = array(
	            "draw" => $draw,
	            "recordsTotal"    => $this->video_model->countListByTime($video_thoigian),
	            "recordsFiltered" => $this->video_model->countListByTime($video_thoigian),
	            "data" => $data
	        );
	        echo json_encode($output);
    	}
    	else
    		echo json_encode("403 forbidden");
    }

    public function filter()
    {
    	if($this->login())
    	{
    		$data = array();
    		$columns = array("video_id","cam_ten","video_thoigian");
    		$fromtime = $this->input->post("fromtime");
    		$totime = $this->input->post("totime");
    		$camera = $this->input->post("camera");
    		$limit = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $order = $this->input->post('order');
	        $order = $order[0];
	        $column = $order['column'];
	        $column = $columns[$column];
	        $sort = $order['dir'];
    		$listVideo = $this->video_model->filter($fromtime,$totime,$camera,$limit,$length,$draw,$column,$sort);
    		foreach($listVideo as $row)
	        {
	        	$sub_array = array();
	            $sub_array[] = $row->video_id;
	            $sub_array[] = $row->cam_ten;
	           	$sub_array[] = $row->video_thoigian;
	           	$sub_array[] = $row->video_url;
	            $data[] = $sub_array;
	        }
	        $output = array(
	            "draw" => $draw,
	            "recordsTotal"    => $this->video_model->countList($fromtime,$totime,$camera),
	            "recordsFiltered" => $this->video_model->countList($fromtime,$totime,$camera),
	            "data" => $data
	        );
	        echo json_encode($output);
    	}
    	else
    		echo json_encode("403 forbidden");
    }

}