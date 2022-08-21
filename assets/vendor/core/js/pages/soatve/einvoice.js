$(document).ready(function () {

	init();

	filterInvoice();

	$("#btnSearchFilter").click(function(e){
		filterInvoice();
	});


	function init()
	{
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var now = d.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;

		$("#timestart").val(now + " 00:00:00");
		$("#timeend").val(now + " 23:59:59");
		$("#time").val(now);

		$('.form_datetime').datetimepicker({
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	    })

	    $('.form_date').datetimepicker({
	    	format: 'yyyy-mm-dd',
	    	pickTime: false,
		    weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			minView: 2,
        	maxView: 4,
		});
	}
	function filterInvoice()
	{
		var type = $('#type :selected').val();
		var lane = $('#lane :selected').val();
		var table = $('#listInvoice').DataTable({
			"destroy": true,
			"bInfo" : true,
			"bLengthChange": false,
			"searching": false,
    		"paging": true,
    		"pageLength": 20,
            processing: true,
            serverSide: true,
            "autoWidth": false,
            order: [[3, 'desc']],
            "ajax":{
            	url: url_filter_einvoice,
            	type: "POST",
            	data: {
            		'time': $('input[name=time]').val(),
            		'timestart': $('input[name=timestart]').val(),
					'timeend': $('input[name=timeend]').val(),
					'type': type,
					'ca': $('#ca').val(),
					'lane': lane
            	},
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull 
            	) {
				if(aData[9] == "Chưa có")
					$('td', nRow).css('background-color', 'Red');
				if(aData[9] == "Chưa kí")
					$('td', nRow).css('background-color', 'Yellow');
			},
		});
	}
	$("#btnExportExcel").click(function(e){
		$('.dataTables_processing').hide();
		$('.dataTables_processing').show();
		var type = $('#type :selected').val();
		var lane = $('#lane :selected').val();
		$.ajax({
			type: "POST",
			url: url_export_invoic_excel,
			data: {
				'time': $('input[name=time]').val(),
        		'timestart': $('input[name=timestart]').val(),
				'timeend': $('input[name=timeend]').val(),
				'type': type,
				'ca': $('#ca').val(),
				'lane': lane
			},
			success:function(data){
				var $a = $("<a>");
			    $a.attr("href",JSON.parse(data).file);
			    $("body").append($a);
			    $a.attr("download",JSON.parse(data).filename);
			    $a[0].click();
			    $a.remove();
			    $('.dataTables_processing').hide();
			    toastr.info("Download file complete");
			}
		});
	});
});