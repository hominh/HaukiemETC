<link href="<?php echo base_url(); ?>assets/vendor/core/css/toastr/toastr.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/vendor/core/js/toastr/toastr.min.js"></script>

<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-md-6 form-group">
						 <form id="upload-form" method="POST" enctype="multipart/form-data">
         					<div class="row align-items-center">
          						<div class="form-group col-md-4">
	            					<label for="inputEmail4">Choose a file:</label>
	            					<input type="file" name="file">
            						<span id="chk-error"></span>
          						</div>
          						<div class="form-group col-md-3">
		                			<label></label>
				                	<div class="form-control-static">
			                       		 <button type="submit" class="btn btn-primary" id="submitExcelDetailTransaction">Upload</button>
			                       	</div>
                    			</div>
                    			<!--<div class="form-group col-md-3">
		                			<label></label>
				                	<div class="form-control-static">
			                       		<input type="button" name="btnBanmoi" id="btnBanmoi" value="Bán mới" class="btn btn-primary btn-flat btn-search">
			                       	</div>
                    			</div>!-->
        					</div>
    					</form>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<label>Giao dịch có ở trung tâm - không có ở trạm</label>
						<table id="listCompare1" class="display" style="width:100%">
							<thead>
					            <tr>
					            	<th></th>
					            	<th>MÃ GIAO DỊCH</th>
					            	<th>ETAG</th>
					            	<th>THỜI GIAN</th>
					                <th>BIỂN SỐ</th>
					                <th>LÀN</th>
					                <th>PHÍ THU</th>
					            </tr>
			        		</thead>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<label>Giao dịch có ở trạm - không có ở trung tâm</label>
						<table id="listCompare2" class="display" style="width:100%">
							<thead>
					            <tr>
					            	<th>ID</th>
					            	<th>MÃ GIAO DỊCH</th>
					            	<th>ETAG</th>
					            	<th>THỜI GIAN</th>
					                <th>BIỂN SỐ</th>
					                <th>LÀN</th>
					                <th>PHÍ THU</th>
					            </tr>
			        		</thead>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<label>Giao dịch lệch giữa trung tâm dữ liệu và trạm</label>
						<table id="listCompare3" class="display" style="width:100%">
							<thead>
					            <tr>
					                <th>MÃ GIAO DỊCH</th>
					            	<th>ETAG</th>
					            	<th>THỜI GIAN</th>
					                <th>BIỂN SỐ FE</th>
					                <th>BIỂN SỐ BE</th>
					                <th>SỐ TIỀN FE</th>
					                <th>SỐ TIỀN BE</th>
					            </tr>
			        		</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/datatables/css/jquery.dataTables.css">
<link type="text/css" href="<?php echo base_url(); ?>assets/vendor/datatables/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/datatables/js/dataTables.checkboxes.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/js/dataTables.keyTable.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/datatables/css/select.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/vendor/datatables/js/dataTables.select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/core/js/pages/comparetransaction/comparetransaction.js"></script>
<script>
	var url_upload_vetc_transaction_file = '<?php echo base_url() . 'comparetransaction/uploadvetctransactionfile/'; ?>';
	var url_compare1 = '<?php echo base_url() . 'comparetransaction/getResultCompare1/'; ?>';
	var url_compare2 = '<?php echo base_url() . 'comparetransaction/getResultCompare2/'; ?>';
	var url_compare3 = '<?php echo base_url() . 'comparetransaction/getResultCompare3/'; ?>';
</script>