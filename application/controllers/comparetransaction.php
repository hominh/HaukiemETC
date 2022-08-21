<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comparetransaction extends My_Controller {
	protected $_data;
	protected $_tolltype;

	public $dataCompare1;

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('param_model');
		$this->load->model('transaction_model');
		$this->load->library('excel');
		$this->dataCompare1 = null;
		$this->_tolltype = $this->param_model->getParamByName('TOOL_TYPE');

	}

	public function index()
	{
		if ($this->login()) {
			$this->_data ['subview'] = 'page/compare';
			$this->load->view('layout/master', $this->_data);
		}
		else
    		$this->load->view ( 'page/login' );
	}

	public function uploadvetctransactionfile()
	{
		if($this->login())
		{
			$arrDatetime = array();
			$this->load->helper(array('form'));
			$config['upload_path']="./assets/upload";
	        $config['allowed_types']='xls|xlsx';
	        $config['encrypt_name'] = TRUE;
	        $this->load->library('upload', $config);
	        ini_set('memory_limit', '2048M');
			if($this->upload->do_upload('file')){

				if($this->_tolltype == 0)
					$isTruncateTransactiontmp = $this->transaction_model->truncateTransactiontmp();

				$data = array('upload_data' => $this->upload->data());
				try {
					$object = PHPExcel_IOFactory::load($data['upload_data']["full_path"]);
					$sheet = $object->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();

					$formatDateTime = "Y-m-d H:i:s";

					if($highestRow >= 9)
					{
						$highestRow = $highestRow - 6;
						for($row = 9; $row <= $highestRow; $row++)
						{
							$vetctransaction_vehicletype = $vetctransaction_lane = $vetctransaction_tickettype = $vetctransaction_price = $vetctransaction_checkinstatus = 0;
							$vetctransaction_committype = 1;
							$vetctransaction_commitstatus = 0;
							$vetctransaction_time = $vetctransaction_ticketid = $vetctransaction_plate = $vetctransaction_tagid =  "";
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
							if($rowData[0][0] != "" || $rowData[0][0] != NULL)
							{
								if($rowData[0][6] == CARTYPE_1_STR)
									$vetctransaction_vehicletype = CARTYPE_1_INT;
								if($rowData[0][6] == CARTYPE_2_STR)
									$vetctransaction_vehicletype = CARTYPE_2_INT;
								if($rowData[0][6] == CARTYPE_3_STR)
									$vetctransaction_vehicletype = CARTYPE_3_INT;
								if($rowData[0][6] == CARTYPE_4_STR)
									$vetctransaction_vehicletype = CARTYPE_4_INT;
								if($rowData[0][6] == CARTYPE_5_STR)
									$vetctransaction_vehicletype = CARTYPE_5_INT;

								if($rowData[0][9] == TICKETTYPE_VELUOT_STR)
									$vetctransaction_tickettype = TICKETTYPE_VELUOT_INT;
								if($rowData[0][9] == TICKETTYPE_VETHANG_STR)
									$vetctransaction_tickettype = TICKETTYPE_VETHANG_INT;
								if($rowData[0][9] == TICKETTYPE_VEQUY_STR)
									$vetctransaction_tickettype = TICKETTYPE_VEQUY_INT;

								$vetctransaction_time = $rowData[0][2];
								$vetctransaction_lane = $rowData[0][19];
								$vetctransaction_ticketid = $rowData[0][1];
								$vetctransaction_tagid = $rowData[0][5];
								$vetctransaction_plate = $rowData[0][4];
								$vetctransaction_price = $rowData[0][15];

								$tmp_vetctransaction_lane = str_split($vetctransaction_lane,4);
								$vetctransaction_lane = $tmp_vetctransaction_lane[1];

								$vetctransaction_time = date($formatDateTime, strtotime(str_replace("/", "-", $vetctransaction_time)));
								$dataInsertTransactiontmp = array(
									"vetctransaction_time" => $vetctransaction_time,
							        "vetctransaction_lane" => $vetctransaction_lane,
							        "vetctransaction_tagid" => $vetctransaction_tagid,
							        "vetctransaction_plate" => $vetctransaction_plate,
							        "vetctransaction_vehicletype" => $vetctransaction_vehicletype,
							        "vetctransaction_ticketid" => $vetctransaction_ticketid,
							        "vetctransaction_tickettype" => $vetctransaction_tickettype,
							        "vetctransaction_price" => $vetctransaction_price,
							        "vetctransaction_startcheckin" => $vetctransaction_time,
							        "vetctransaction_checkinstatus" => $vetctransaction_checkinstatus,
							        "vetctransaction_committype" => $vetctransaction_committype,
							        "vetctransaction_startcommit" => $vetctransaction_time,
							        "vetctransaction_amount" => $vetctransaction_price,
							        "vetctransaction_note" => "Giao dịch bị thiếu"
								);
								$result = $this->transaction_model->insertTmp($dataInsertTransactiontmp);
							}
						}

						$minTimeTransactiontmp = $this->transaction_model->getMinTimeforCompareTransaction();
						$maxTimeTransactiontmp = $this->transaction_model->getMaxTimeforCompareTransaction();
						if($minTimeTransactiontmp[0]->timestart != "" && $minTimeTransactiontmp[0]->timestart != null && !empty($minTimeTransactiontmp[0]->timestart) &&  $maxTimeTransactiontmp[0]->timeend != "" && $maxTimeTransactiontmp[0]->timeend != null && !empty($maxTimeTransactiontmp[0]->timeend))
						{
							$maxTimeTransactiontmp = $maxTimeTransactiontmp[0]->timeend;
							$minTimeTransactiontmp = $minTimeTransactiontmp[0]->timestart;
							array_push($arrDatetime,$minTimeTransactiontmp);
							array_push($arrDatetime,$maxTimeTransactiontmp);
							echo json_encode($arrDatetime);
						}
						else
						{
							echo json_encode("Invalid starttime and endtime");
							return;
						}
					}
				}
				catch(Exception $e)
				{
					echo json_encode($e);
					return;
				}
			}
			else{
				echo json_encode("Invalid upload file");
				return;
			}
		}
		else {
			echo json_encode("403 forbiden");
		}
	}


	public function getResultCompare1()
	{
		$minTimeTransactiontmp = $this->input->post("timestart");
		$maxTimeTransactiontmp = $this->input->post("timeend");
		$compare1 = $this->transaction_model->compareVETCGetTransactionNotFoundInCadpro($minTimeTransactiontmp,$maxTimeTransactiontmp);
		foreach($compare1 as $row)
        {
        	$sub_array = array();
        	$sub_array[] = $row->vetctransaction_id;
            $sub_array[] = $row->vetctransaction_ticketid;
            $sub_array[] = $row->vetctransaction_tagid;
           	$sub_array[] = $row->vetctransaction_time;
           	$sub_array[] = $row->vetctransaction_plate;
           	$sub_array[] = $row->vetctransaction_lane;
           	$sub_array[] = $row->vetctransaction_price;
            $data[] = $sub_array;
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
	}

	public function getResultCompare2()
	{
		$minTimeTransactiontmp = $this->input->post("timestart");
		$maxTimeTransactiontmp = $this->input->post("timeend");
		$compare2 = $this->transaction_model->compareVETCGetTransactionNotFoundInVETC($minTimeTransactiontmp,$maxTimeTransactiontmp);
		foreach($compare2 as $row)
        {
        	$sub_array = array();
        	$sub_array[] = $row->vetctransaction_id;
            $sub_array[] = $row->vetctransaction_ticketid;
            $sub_array[] = $row->vetctransaction_tagid;
           	$sub_array[] = $row->vetctransaction_time;
           	$sub_array[] = $row->vetctransaction_plate;
           	$sub_array[] = $row->vetctransaction_lane;
           	$sub_array[] = $row->vetctransaction_price;
            $data[] = $sub_array;
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
	}

	public function getResultCompare3()
	{
		$minTimeTransactiontmp = $this->input->post("timestart");
		$maxTimeTransactiontmp = $this->input->post("timeend");
		$compare3 = $this->transaction_model->compareVETCGetTransactionInvalid($minTimeTransactiontmp,$maxTimeTransactiontmp);
		foreach($compare3 as $row)
        {
        	$sub_array = array();
            $sub_array[] = $row->vetctransaction_ticketid;
            $sub_array[] = $row->vetctransaction_tagid;
           	$sub_array[] = $row->vetctransaction_time;
           	$sub_array[] = $row->plateCPR;
           	$sub_array[] = $row->plateVETC;
           	$sub_array[] = $row->priceCPR;
           	$sub_array[] = $row->priceVETC;
            $data[] = $sub_array;
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
	}
}