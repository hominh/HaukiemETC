<link href="<?php echo base_url(); ?>assets/vendor/core/css/toastr/toastr.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/vendor/core/js/toastr/toastr.min.js"></script>
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
	                	<label>Ca</label>
	                	<input type="text" class="form-control" id="ca" name="ca" value="">
	               	</div>
	               	<div class="col-md-1 form-group">
	                	<label>Ngày</label>
	                	<input type="text" class="form-control" id="day" name="day" value="">
	               	</div>
	               	<div class="col-md-1 form-group">
	                	<label>Tháng</label>
	                	<select class="form-control" style="width: 100%;" id="month" name="month">
	                	</select>
	               	</div>
	               	<div class="col-md-1 form-group">
	                	<label>Năm</label>
	                	<input type="text" class="form-control" id="year" name="year" value="">
	               	</div>
	               	<div class="col-md-2">
	               		<label></label>
	               		<div class="form-control-static">
	               			<button class="btn btn-primary btn-flat btn-search" id="generateReport"><i class="fa fa-file-pdf-o"></i>Download</button>
	               		</div>
	               	</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>
							<b>Chọn báo cáo</b>
						</label>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="7">
	  						Báo cáo doanh thu ETC theo thời gian sau điều chỉnh
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="0">
  							Báo cáo doanh thu ETC theo ngày sau điều chỉnh
  						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="1">
	  						Báo cáo doanh thu ETC theo tháng sau điều chỉnh
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="2">
	  						Báo cáo doanh thu ETC theo năm sau điều chỉnhreport
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="3">
	  						Báo cáo lưu lượng ETC theo thời gian sau điều chỉnh
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="4">
	  						Báo cáo lưu lượng ETC theo ngày sau điều chỉnh
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="5">
	  						Báo cáo lưu lượng ETC theo tháng sau điều chỉnh
	  					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-check-input" type="radio" name="report" id="report" value="6">
	  						Báo cáo lưu lượng ETC theo năm sau điều chỉnh
	  					</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/core/js/pages/report/report.js"></script>
<script>
	var url_generate_report = '<?php echo base_url() . 'report/getParamReport/'; ?>';
</script>