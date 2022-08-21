<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soatve extends My_Controller {
	protected $_data;
	protected $companyName;
	protected $tollName;

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('soatve_model');
		$this->load->model('lane_model');
		$this->load->model('cartype_model');
		$this->load->model('employee_model');
		$this->load->model('cam_model');
		$this->load->model('param_model');
		$this->load->library('excel');

		$this->companyName = $this->param_model->getParamByName('DonVi');
		$this->tollName = $this->param_model->getParamByName('TramThuPhi');
	}

	public function index()
	{
		if ($this->login()) {
			$this->_data['soatvevien'] = $this->employee_model->findEmployeeByRole(BIT6);
			$this->_data['lanes'] = $this->lane_model->getList();
			$this->_data['cartypes'] = $this->cartype_model->getList();
			$this->_data['cams'] = $this->cam_model->getList();
			$this->_data ['subview'] = 'page/soatve';
			$this->load->view('layout/master', $this->_data);
		}
		else
    		$this->load->view ( 'page/login' );
	}

	public function filter()
	{
		if ($this->login()) {
			$data = array();
			$columns = array("idsoatve","ngaygio","lanxe","bienso","plateetag","mave","vetctransaction_committype","loaive","loaixe","phithu","soatvevien");

			$timestart = $this->input->post("timestart");
			$timeend = $this->input->post("timeend");
			$plate = $this->input->post("plate");
			$barcode = $this->input->post("barcode");
			$employee = $this->input->post("employee");
			$lane = $this->input->post("lane");
	        $cartype = $this->input->post("cartype");
	        $platetype = $this->input->post("platetype");
	        $transactiontype = $this->input->post("transactiontype");
	        $tickettype = $this->input->post("tickettype");
	        $freec = $this->input->post("freec");
	        $freedc = $this->input->post("freedc");
	        $isMoney = $this->input->post("isMoney");
	        $tickettypevetc = $this->input->post("tickettypevetc");
	        $limit = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        //var_dump($this->input->post('order')['0']['column']);
	        $order = $this->input->post('order');
	        $order = $order[0];
	        $column = $order['column'];
	        $column = $columns[$column];
	        //$column = $columns[$this->input->post('order')['0']['column']];
	        $sort = $order['dir'];
	        //$sort = $this->input->post('order')['0']['dir'];
	        //die();
	        
	        $this->_data ['listSoatve'] = $this->soatve_model->getListSoatve($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc,$limit,$length,$draw,$column,$sort);
	        foreach($this->_data ['listSoatve'] as $row)
	        {
	        	$sub_array = array();
	            $sub_array[] = $row->idsoatve;
	            $sub_array[] = $row->ngaygio;
	            $sub_array[] = $row->lanxe;
	            $sub_array[] = $row->bienso;
	            $sub_array[] = $row->plateetag;
	            $sub_array[] = $row->mave;
	            $sub_array[] = $row->vetctransaction_committype;
	            $sub_array[] = $row->loaive;
	            $sub_array[] = $row->loaixe;
	            $sub_array[] = $row->phithu;
	            $sub_array[] = $row->soatvevien;
	            $sub_array[] = $row->anhlanxe;
	            $sub_array[] = $row->anhbienso;
	            $sub_array[] = $row->tagid;
	            //$sub_array[] = $row->;
	            $data[] = $sub_array;
	        }
	        $output = array(
	            "draw" => $draw,
	            "recordsTotal"    => $this->soatve_model->getCountListSoatve($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc),
	            "recordsFiltered" => $this->soatve_model->getCountListSoatve($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc),
	            "data" => $data
	        );
	        echo json_encode($output);
	    }
		else {
			 echo json_encode("403 forbidden");
		}
	}

	public function updatePlate()
	{
		if($this->login()) {
			$soatve_id = $this->input->post("soatve_id");
			$plate_old = $this->input->post("plate_old");
			$data_update = array(
				"soatve_bienso" => $this->input->post("plate")
	        );
			$result = $this->soatve_model->updatePlate($data_update,$soatve_id);
			if($result == 1)
			{
				$date = date('Y-m-d H:i:s');
				$dataval = $this->session->userdata('logged_in');
		    	$userid = $dataval['id'];
				$content = "Cập nhật biển số cho lượt soát vé " . $soatve_id;
				$content.= ". Biến số cũ: " . $plate_old;
				$content.= "; biển số mới: " .$this->input->post("plate");
				$data_inserLog = array(
					"log_time" => $date,
			        "log_user" => $userid,
			        "log_type" => 3,
			        "log_description" => $content
				);
				$this->writeLog($data_inserLog);
			}
	    	echo $result;
    	}
    	else {
    		echo json_encode("403 forbidden");
    	}
	}

	public function getListByPlate()
	{
		if($this->login())
		{
			$plate = $this->input->post("plate");
			$listSoatve = $this->soatve_model->getListByPlate($plate);
			foreach($listSoatve as $row)
	        {
	        	$sub_array = array();
	            $sub_array[] = $row->soatve_id;
	            $sub_array[] = $row->soatve_ngaygio;
	            $sub_array[] = $row->soatve_malan;
	            $sub_array[] = $row->soatve_bienso;
	            $sub_array[] = $row->soatve_mave;
	            $sub_array[] = $row->soatve_loaixe;
	            $sub_array[] = $row->soatve_phithu;
	            $data[] = $sub_array;
	        }
	        $output = array(
	            "draw" => 1,
	            "recordsTotal"    => 5,
	            "recordsFiltered" => 5,
	            "data" => $data
	        );
	        echo json_encode($output);
		}
		else {
    		echo json_encode("403 forbidden");
    	}
	}

	public function export()
	{
		if($this->login())
		{
			$timestart = $this->input->post("timestart");
			$timeend = $this->input->post("timeend");
			$plate = $this->input->post("plate");
			$barcode = $this->input->post("barcode");
			$employee = $this->input->post("employee");
			$lane = $this->input->post("lane");
	        $cartype = $this->input->post("cartype");
	        $platetype = $this->input->post("platetype");
	        $transactiontype = $this->input->post("transactiontype");
	        $tickettype = $this->input->post("tickettype");
	        $freec = $this->input->post("freec");
	        $freedc = $this->input->post("freedc");
	        $isMoney = $this->input->post("isMoney");
	        $tickettypevetc = $this->input->post("tickettypevetc");
			$styleArrayHeader = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 16,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayReportName = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayParam = array(
			    'font'  => array(
			        'bold'  => false,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayData = array(
			    'font'  => array(
			        'bold'  => false,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    ),
			    'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		),
        		'borders' => array(
			        'allborders' => array(
			            'style' => PHPExcel_Style_Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);

			$styleArrayHeaderColumn = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    ),
			    'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		),
        		'borders' => array(
			        'allborders' => array(
			            'style' => PHPExcel_Style_Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);

			$sumTransaction = 0;
			$listSoatve = $this->soatve_model->getListSoatve2ExportExcel($timestart,$timeend,$plate,$barcode,$employee,$lane,$cartype,$platetype,$transactiontype,$tickettype,$freec,$freedc,$isMoney,$tickettypevetc);
			$sumTransaction = count($listSoatve);
			$sumTransactionStr = "Tổng số giao dịch: ".$sumTransaction;

			$countETC = $countMTC = 0;
			//$percentValidPlateStr = "Số ";

			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('CHI TIẾT GIAO DICH');
			$this->excel->getActiveSheet()->mergeCells('A1:L1');
			$this->excel->getActiveSheet()->mergeCells('A2:L2');

			$this->excel->getActiveSheet()->setCellValue('A1', $this->companyName);
			$this->excel->getActiveSheet()->setCellValue('A2', $this->tollName);
			$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayHeader);
			$this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArrayHeader);

			$this->excel->getActiveSheet()->mergeCells('G4:L4');
			$this->excel->getActiveSheet()->mergeCells('F5:N5');
			$this->excel->getActiveSheet()->setCellValue('G4', 'CHI TIẾT GIAO DỊCH TRONG CA');
			$this->excel->getActiveSheet()->setCellValue('F5', 'IN RA PHỤC VỤ THANH KIỂM TRA HOẶC XỬ LÝ KHIẾU NẠI');
			$this->excel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArrayReportName);
			$this->excel->getActiveSheet()->getStyle('F5')->applyFromArray($styleArrayReportName);

			for($i = 6; $i <=10; $i++)
				$this->excel->getActiveSheet()->mergeCells("A".$i.":F".$i."");

			foreach(range('A','H') as $columnID) {
    			$this->excel->getActiveSheet()->getColumnDimension($columnID)
        				->setAutoSize(true);
			}

			$timestartStr = "Bắt đầu lúc: " .$timestart;
			$timeendStr = "Kết thúc lúc: " .$timeend;

			for($i = 0; $i < count($listSoatve); $i++)
			{
				/*if($listSoatve[$i]->CHECKED == "OK")
					$validPlate++;*/
				if(strlen(strstr($listSoatve[$i]->loaive,"ETC")) > 0)
					$countETC ++;

				$index = $i + 1;
				$row = $i + 13;
				$this->excel->getActiveSheet()->setCellValue("A".$row."", $index);
				$this->excel->getActiveSheet()->setCellValue("B".$row."", $listSoatve[$i]->ngaygio);
				$this->excel->getActiveSheet()->setCellValue("C".$row."", $listSoatve[$i]->lanxe);
				$this->excel->getActiveSheet()->setCellValue("D".$row."", $listSoatve[$i]->mave);
				$this->excel->getActiveSheet()->setCellValue("E".$row."", $listSoatve[$i]->bienso);
				$this->excel->getActiveSheet()->setCellValue("F".$row."", $listSoatve[$i]->plateetag);
				$this->excel->getActiveSheet()->setCellValue("G".$row."", $listSoatve[$i]->loaive);
				$this->excel->getActiveSheet()->setCellValue("H".$row."", $listSoatve[$i]->vetctransaction_committype);
				$this->excel->getActiveSheet()->setCellValue("I".$row."", $listSoatve[$i]->phithu);

			}
			$countMTC = $sumTransaction - $countETC;
			$countMTC = "Số giao dịch MTC: ".$countMTC;
			$countETC = "Số giao dịch ETC: ".$countETC;

			$this->excel->getActiveSheet()->setCellValue('A12', 'STT');
			$this->excel->getActiveSheet()->setCellValue('B12', 'Ngày giờ');
			$this->excel->getActiveSheet()->setCellValue('C12', 'Làn');
			$this->excel->getActiveSheet()->setCellValue('D12', 'Mã vé');
			$this->excel->getActiveSheet()->setCellValue('E12', 'Biển số nhận dạng');
			$this->excel->getActiveSheet()->setCellValue('F12', 'Biển số etag');
			$this->excel->getActiveSheet()->setCellValue('G12', 'Loại vé');
			$this->excel->getActiveSheet()->setCellValue('H12', 'Giao dịch');
			$this->excel->getActiveSheet()->setCellValue('I12', 'Phí thu');

			$this->excel->getActiveSheet()->setCellValue('A6', $timestartStr);
			$this->excel->getActiveSheet()->setCellValue('A7', $timeendStr);
			$this->excel->getActiveSheet()->setCellValue('A8', $sumTransactionStr);
			$this->excel->getActiveSheet()->setCellValue('A9', $countETC);
			$this->excel->getActiveSheet()->setCellValue('A10', $countMTC);

			$this->excel->getActiveSheet()->getStyle('A6:I10')->applyFromArray($styleArrayParam);
			$this->excel->getActiveSheet()->getStyle("A12:I12")->applyFromArray($styleArrayHeaderColumn);
			$tmpSumTransaction = $sumTransaction + 12;
			$this->excel->getActiveSheet()->getStyle("A13:I".$tmpSumTransaction."")->applyFromArray($styleArrayData);


			$filename ='soatve.xls';
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			ob_start();
			$objWriter->save("php://output");
			$xlsData = ob_get_contents();
			ob_end_clean();
	        $response =  array(
	            'status' => TRUE,
	            'filename' => $filename,
	            'file' => "data:application/vnd.ms-excel;base64,". base64_encode($xlsData)
	        );
        	die(json_encode($response));
		}
		else {
			die("403 forbidden");
		}
	}
}
