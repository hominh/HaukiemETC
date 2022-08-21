<link href="<?php echo base_url(); ?>assets/vendor/core/css/toastr/toastr.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/vendor/core/js/toastr/toastr.min.js"></script>
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-md-1 form-group">
	                	<label>Hình thức</label>
	                	<select class="form-control" style="width: 100%;" id="type" name="type">
	                		<option value="0">Theo ca</option>
	                		<option value="1">Theo ngày</option>
	                		<option value="2">Theo thời gian</option>
	                    </select>
	                </div>
	                <div class="col-md-2 form-group">
						<label>Ngày</label>
						<div class="input-group date form_date col-md-12"data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
	            			<input class="form-control" size="16" type="text" value="" name="time" id="time">
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        				</div>
					</div>
					<div class="col-md-1 form-group">
	                	<label>Ca</label>
	                	<select class="form-control" style="width: 100%;" id="ca" name="ca">
	                		<option value="1">1</option>
	                		<option value="2">2</option>
	                		<option value="2">3</option>
	                    </select>
	                </div>
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
	                	<label>Làn xe</label>
	                	<select class="form-control" style="width: 100%;" id="lane" name="lane">
	                		<option value="0">Tất cả</option>
	                		<?php foreach ($lanes as $item): ?>
								<?php echo "<option value='$item->lanxe_id'>";  ?>
								<?php echo "Làn số " .$item->lanxe_id;?>
	                        <?php endforeach ?>
	                    </select>
	                </div>
	                <div class="col-md-2">
	                	<label></label>
	                	<div class="form-control-static">
                       		<button class="btn btn-primary btn-flat btn-search" id="btnSearchFilter"><i class="fa fa-search"></i>Lọc</button>
                       		<button class="btn btn-primary btn-flat btn-search" id="btnExportExcel"><i class="fa fa-file-excel-o"></i>Excel</button>
                       	</div>
                    </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table id="listInvoice" class="display" style="width:100%">
			        <thead>
			            <tr>
			            	<th>MÃ GIAO DỊCH</th>
			            	<th>THỜI GIAN</th>
			            	<th>BIỂN SỐ</th>
			            	<th>LÀN</th>
			                <th>LOẠI PHIẾU THU</th>
			                <th>ĐƠN GIÁ</th>
			                <th>MÃ TRA CỨU</th>
			                <th>TRẠNG THÁI PT</th>
			                <th>TRẠNG THÁI HĐ CPR</th>
			                <th>TRẠNG THÁI HĐ VETC</th>
			            </tr>
			        </thead>
				</table>
			</div>
		</div>
	</section>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/datatables/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.js"></script>
<script>
	var url_filter_einvoice = '<?php echo base_url() . 'einvoice/filter/'; ?>';
	var url_export_invoic_excel = '<?php echo base_url() . 'einvoice/export/'; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/core/js/pages/soatve/einvoice.js"></script>