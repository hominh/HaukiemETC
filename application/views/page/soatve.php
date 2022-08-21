<link href="<?php echo base_url(); ?>assets/vendor/core/css/toastr/toastr.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/vendor/core/js/toastr/toastr.min.js"></script>
<style>
	tr.row_selected td{background-color:#d73925 !important;}
	#listSoatve tr td:nth-child(12), #listSoatve tr th:nth-child(12) {
    	display:none;
	}
	#listSoatve tr td:nth-child(13), #listSoatve tr th:nth-child(13) {
    	display:none;
	}
	#listSoatve tr td:nth-child(14), #listSoatve tr th:nth-child(14) {
    	display:none;
	}
	#listVideo tr td:nth-child(4), #listVideo tr th:nth-child(4) {
    	display:none;
	}
	video {
  		width: 100%    !important;
  		height: auto   !important;
	}
</style>
<div class="modal fade modal-confirm-delete"  id="modalPlayback" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="min-width:80%; min-height: 100% !important;">
		<div class="modal-content">
			<div class="modal-header bg-danger">
                <h4 class="modal-title"><i class="til_img"></i><strong>Playback</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-2 form-group">
						<label>Từ ngày</label>
						<div class="input-group date form_datetime col-md-12"data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
	            			<input class="form-control" size="16" type="text" value="" name="timestartVideo" id="timestartVideo">
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        				</div>
					</div>
					<div class="col-md-2 form-group">
						<label>Đến ngày</label>
						<div class="input-group date form_datetime col-md-12"data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
	            			<input class="form-control" size="16" type="text" value="" name="timeendVideo" id="timeendVideo">
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        				</div>
					</div>
					<div class="col-md-4 form-group">
	                	<label>Camera</label>
	                	<select class="form-control" style="width: 100%;" id="camera" name="camera">
	                		<option value="0">Tất cả</option>
	                		<option value="0">Tất cả</option>
	                		<?php foreach ($cams as $item): ?>
								<?php echo "<option value='$item->cam_id'>";  ?>
								<?php echo $item->cam_ten;?>
	                        <?php endforeach ?>
	                    </select>
	                </div>
            	</div>
            	<div class="row">
            		<div class="col-md-8">
            			<video autoplay="autoplay" controls muted id="videoView" src=""></video>
            		</div>
            		<div class="col-md-4">
            			<table id="listVideo" class="display" style="width:100%">
		  					<thead>
		  						<th>#</th>
		  						<th>CAMERA</th>
		  						<th>THỜI GIAN</th>
		  						<th>URL</th>
		  					</thead>
		  				</table>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-8">
            			<button type="button" class="btn btn-primary btn-circle" id="pauseVideo" title="Pause"><i class="fa fa-pause"></i></button>
            			<button type="button" class="btn btn-primary btn-circle" id="playVideo" disabled title="Play"><i class="fa fa-play"></i></button>
            			<button type="button" class="btn btn-primary btn-circle" id="prevVideo" title="Previous"><i class="fa fa-fast-backward"></i></button>
            			<button type="button" class="btn btn-primary btn-circle" id="nextVideo" title="Next"><i class="fa fa-fast-forward"></i></button>
            			<button type="button" class="btn btn-primary btn-circle" id="speedDownVideo" title="Speed down"><i class="fa fa-backward"></i></button>
            			<button type="button" class="btn btn-primary btn-circle" id="speedUpVideo" title="Speed up"><i class="fa fa-forward"></i></button>
            			<input type="checkbox" class="form-check-input" id="isNextVideo" name="isNextVideo" value="">
      					<label class="form-check-label" for="check1">Xem tự động</label>
            			&nbsp;&nbsp;
            			<strong id="time"></strong>
            			
            		</div>
            	</div>
            </div>
		</div>
	</div>
</div>
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-md-2 form-group">
						<label>Từ ngày</label>
						<div class="input-group date form_datetime col-md-12"data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
	            			<input class="form-control" size="16" type="text" value="" name="timestart" id="timestart">
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        				</div>
					</div>
					<div class="col-md-2 form-group">
                    	<label>Đến ngày</label>
	                    <div class="input-group date form_datetime col-md-12"data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
	        				<input class="form-control" size="16" type="text" value="" name="timeend" id="timeend">
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	    				</div>
                	</div>
	                <div class="col-md-1 form-group">
	                	<label>Biển số</label>
	                	<input type="text" class="form-control" id="plate" name="plate" value="">
	               	</div>
	               	<div class="col-md-1 form-group">
	                	<label>Nhân viên</label>
	                	<select class="form-control" style="width: 100%;" id="employee" name="employee">
	                		<option value="0">Tất cả</option>
	                		<?php foreach ($soatvevien as $item): ?>
								<?php echo "<option value='$item->nsd_id'>";  ?>
								<?php echo $item->nsd_ten;?>
	                        <?php endforeach ?>
	                    </select>
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Làn xe</label>
	                	<select class="form-control" style="width: 100%;" id="lane" name="lane">
	                		<option value="0">Tất cả</option>
	                		<?php foreach ($lanes as $item): ?>
								<?php echo "<option value='$item->lanxe_id'>";  ?>
								<?php echo "Làn số " .$item->lanxe_id;?>
	                        <?php endforeach ?>
	                    </select>
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Loại xe</label>
	                	<select class="form-control" style="width: 100%;" id="cartype" name="cartype">
	                		<option value="0">Tất cả</option>
	                		<?php foreach ($cartypes as $item): ?>
								<?php echo "<option value='$item->loaixe_id'>";  ?>
								<?php echo $item->loaixe_ten;?>
	                        <?php endforeach ?>
	                    </select>
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Mã vé</label>
	                	<input type="text" class="form-control" id="barcode" name="barcode">
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Loại BS</label>
	                	<select class="form-control" style="width: 100%;" id="platetype" name="platetype">
	                        <option value="A">Tất cả</option>
	                        <option value="T">Biển trắng</option>
	                        <option value="X">Biển xanh</option>
	                        <option value="V">Biển vàng</option>
	                    </select>
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Giao dịch</label>
	                	<select class="form-control" style="width: 100%;" id="transactiontype" name="transactiontype">
	                        <option value="3">Tất cả</option>
	                        <option value="0">Pending</option>
	                        <option value="1">Commit</option>
	                        <option value="2">Rollback</option>
	                    </select>
	                </div>
	                <div class="col-md-1 form-group">
	                	<label>Kiểm duyệt</label>
	                	<select class="form-control" style="width: 100%;" id="isCheck" name="isCheck">
	                        <option value="0">Tất cả</option>
	                        <option value="1">Xe đã kiểm duyệt</option>
	                        <option value="2">Xe chưa kiểm duyệt</option>
	                    </select>
	                </div>
				</div>
				<div class="row">
                <div class="col-md-9">
                	<span>
                		<div class="checkbox">
                			<label>
        						<input type="checkbox" name="tickettype" id="dayticket" value="1">Vé lượt
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="tickettype" id="monthticket" value="2,3">Vé tháng/quý
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="tickettype" id="btcticket" value="10">BTC
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" id="mpdc" name="tickettype" value="11">MP đơn chiếc
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="tickettype" id="tickettype" value="12">MP theo đoàn
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="freedc" id="freedc" value="">MP đoàn cơ
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="tickettype" id="etcday" value="5">ETC lượt
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" id="etcmonth" name="tickettype" value="6,7">ETC trả trước
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="tickettype" id="etcoffline" value="15">ETC Offline
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" id="etcmpkv" name="tickettype" value="8">ETC MPKV
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" id="etcmienphi" name="tickettype" value="8">ETC Miễn phí
      						</label>
      						<label>
        						<input type="checkbox" name="tickettype" id="xvt" value="0">Xe vượt trạm
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="freec" id="freec">Miễn phí cơ
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="money" id="nomoney">Vé 0 đồng
      						</label>
      						&nbsp;&nbsp;
      						<label>
        						<input type="checkbox" name="money" id="hasmoney">Vé có tiền
      						</label>
      					</div>
                	</span>
                </div>
                <div class="col-md-3">
		    		<div class="col-md-3">
		    			<button-search>
                            <button class="btn btn-primary btn-flat btn-search" id="btnSearch"><i class="fa fa-search"></i>Lọc</button>
                        </button-search>
                    </div>
                    <div class="col-md-4">
		    			<button-search>
                            <button class="btn btn-info btn-flat btn-search" id="btnUpdatePlate"><i class="fa fa-edit"></i>Sửa biển số</button>
                        </button-search>
                    </div>
                    <div class="col-md-3">
		    			<button-search>
                            <button class="btn btn-warning btn-flat btn-search" id="btnExport"><i class="fa fa-file-excel-o"></i>File excel</button>
                        </button-search>
                    </div>
		    	</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table id="listSoatve" class="display" style="width:100%" tabindex="0">
			        <thead>
			            <tr>
			            	<th>#</th>
			                <th>THỜI GIAN</th>
			                <th>LÀN</th>
			                <th>Biển số</th>
			                <th>Biển số ETAG</th>
			                <th>MÃ VÉ</th>
			                <th>GIAO DỊCH</th>
			                <th>LOẠI VÉ</th>
			                <th>LOẠI XE</th>
			                <th>PHÍ THU</th>
			                <!--<th>LỖI</th>!-->
			                <th>NHÂN VIÊN BÁN VÉ</th>
			            </tr>
			        </thead>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 form-group">
				<div class="col-md-6" style="padding-left: 0px !important;">
					<img src="" id="image_lane" class="img-responsive">
				</div>
				<div class="col-md-6">
					<img src="" id="image_bienso" class="img-responsive">
				</div>
			</div>
			<div class="col-md-3 form-group">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#info_transaction" aria-controls="info_transaction" role="tab" data-toggle="tab" >Giao dịch ETC</a></li>
					<li role="presentation"><a href="#info_vehicle" aria-controls="info_vehicle" role="tab" data-toggle="tab" >Xe chuẩn</a></li>
					<li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab" >Lịch sử</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="info_transaction">
						<div class="box box-primary">
							<input type="hidden" name="soatve_id" id="soatve_id" value="" readonly>
							<input type="hidden" name="plate_old" id="plate_old" value="" readonly>
							<div class="box-body">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Biển số</label>
		                  				<input type="text" class="form-control" id="changetransaction_plate" name="changetransaction_plate" readonly>
									</div>
									<div class="form-group">
	          							<label for="exampleInputEmail1">Mã giao dịch</label>
	          							<input type="text" class="form-control" id="changetransaction_ticketid" name="changetransaction_ticketid" readonly>
	        						</div>
	        					</div>
	        					<div class="col-md-6">
	        						<div class="form-group">
	          							<label for="exampleInputEmail1">ETAG</label>
	          							<input type="text" class="form-control" id="changetransaction_etag" name="changetransaction_etag" readonly>
	        						</div>
	        						<div class="form-group">
	          							<label for="exampleInputEmail1">Loại giao dịch</label>
	          							<input type="text" class="form-control" id="changetransaction_type" name="changetransaction_type" readonly>
	        						</div>
	        					</div>
	        					<div class="col-md-12">
		        					<button type="button" id="commitbutton" class="btn btn-primary"><i class="fa fa-cloud-upload"></i>Commit GD</button>
									<button type="button" id="lockbutton" class="btn btn-danger"><i class="fa fa-times"></i>Khóa GD</button>
									<button class="btn btn-primary btn-flat" id="btnPlayback"><i class="fa fa-video-camera"></i>Playback</button>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="info_vehicle">
		  				<div class="box box-primary">
		  					<div class="box-body">
		  						<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Biển số</label>
		                  				<input type="text" class="form-control" id="trueplate" name="trueplate">
									</div>
									<div class="form-group">
	          							<label for="exampleInputEmail1">Loại xe</label>
	          							<select class="form-control" style="width: 100%;" id="truevehicletype" name="truevehicletype">
					                		<?php foreach ($cartypes as $item): ?>
												<?php echo "<option value='$item->loaixe_id'>";  ?>
												<?php echo $item->loaixe_ten;?>
					                        <?php endforeach ?>
				                        </select>
	        						</div>
	        					</div>
	        					<div class="col-md-6">
	        						<div class="form-group">
	          							<label for="exampleInputEmail1">Ngày nhập</label>
	          							<input type="text" class="form-control" id="datesavetruevehicle" name="datesavetruevehicle">
	        						</div>
	        						<div class="form-group">
	          							<label for="exampleInputEmail1">Người nhập</label>
	          							<input type="text" class="form-control" id="employeesavetruevehicle" name="employeesavetruevehicle">
	        						</div>
	        					</div>
	        					<div class="col-md-3">
	        						<input type="checkbox" class="form-check-input" id="isWarning" name="isWarning" value="">
      								<label class="form-check-label" for="check1">Cảnh báo</label>
	        					</div>
	        					<div class="col-md-9">
	        						<div class="input-group">
  										<input type="text" class="form-control" id="notetruevehicle" name="notetruevehicle">
  										<span class="input-group-btn">
    										<button class="btn btn-default" type="button" id="btnUpdateTrueVehicle"><i class="fa fa-pencil-square-o"></i>&nbsp;Cập nhật</button>
  										</span>
									</div>
	        					</div>
		  					</div>
		  				</div>
		  			</div>
		  			<div role="tabpanel" class="tab-pane" id="history">
		  				<table id="listHistory" class="display" style="width:100%">
		  					<thead>
		  						<th>#</th>
		  						<th>THỜI GIAN</th>
		  						<th>LÀN</th>
		  						<th>Biển số</th>
		  						<th>MÃ VÉ</th>
		  						<th>LOẠI XE</th>
			                	<th>PHÍ THU</th>
		  					</thead>
		  				</table>
		  			</div>
		  		</div>
			</div>
		</div>
	</section>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/datatables/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/datatables/css/keyTable.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/vendor/datatables/js/dataTables.keyTable.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/datatables/css/select.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/vendor/datatables/js/dataTables.select.js"></script>
<script>
	var url_listsoatve = '<?php echo base_url() . 'soatve/filter/'; ?>';
	var url_getvehiclebyplate = '<?php echo base_url() . 'vehicle/getVehicleByPlate/' ?>';
	var url_getListByPlate = '<?php echo base_url() . 'soatve/getListByPlate/' ?>';
	var url_videofilter = '<?php echo base_url() . 'video/filter/'; ?>';
	var url_vehicleupdate = '<?php echo base_url() . 'vehicle/update/'; ?>';
	var url_changecommittype = '<?php echo base_url() . 'transaction/changeCommitType/'; ?>';
	var url_locktransaction = '<?php echo base_url() . 'transaction/lockTransaction/'; ?>';
	var url_updateplate = '<?php echo base_url() . 'soatve/updatePlate/'; ?>';
	var url_getlistvideobytime = '<?php echo base_url() . 'video/getListByTime/' ?>';
	var url_export_excel = '<?php echo base_url() . 'soatve/export/'; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/core/js/pages/soatve/soatve.js"></script>