$(document).ready(function () {

	var table;
	var table2;
	var table3

	$("#btnBanmoi").click(function(e) {
    	var rows_selected = table.column(0).checkboxes.selected();
    	$.each(rows_selected, function(index, rowId){
    		console.log(rowId);
    	});
	});

	$('form#upload-form').submit(function (e){
		$('.loader').hide();
		$('.loader').show();
		e.preventDefault();
      	e.stopImmediatePropagation();
      	var formData = new FormData($(this)[0]);
       	$.ajax({
       		type:'POST',
       		url: url_upload_vetc_transaction_file,
       		//beforeSend: function() { $('.loader').show(); },
       		data: formData,
       		cache:false,
          	contentType: false,
          	processData: false,
          	success: function (data) {
          		if (!jQuery.parseJSON(data)[0] || !jQuery.parseJSON(data)[1])
          			toastr.error("Error");
          		else
          		{
          			loadListTransactionCompare1(jQuery.parseJSON(data)[0],jQuery.parseJSON(data)[1]);
          			loadListTransactionCompare2(jQuery.parseJSON(data)[0],jQuery.parseJSON(data)[1]);
          			loadListTransactionCompare3(jQuery.parseJSON(data)[0],jQuery.parseJSON(data)[1]);
          		}
            },
            error: function (xhr, ajaxOptions, thrownError) {
              	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
       	});
       	//
       	return false;
	});

	function loadListTransactionCompare1(timestart,timeend)
	{
		table = $('#listCompare1').DataTable({
			"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
			"paging": false,
			//processing: true,
            serverSide: true,
            "autoWidth": false,
            keys: true,
            select: true,
            'columnDefs': [
	         	{
	            	'targets': 0,
	            	'checkboxes': {
	               		'selectRow': true
	            	}
	         	}
      		],
	      	'select': {
	         	'style': 'multi'
	      	},
	      	order: [[1, 'desc']],
            "ajax":{
            	url: url_compare1,
            	type: "POST",
            	data: {
            		"timestart": timestart,
            		"timeend": timeend
            	}
            },
		});
		$('.loader').hide();
	}

	function loadListTransactionCompare2(timestart,timeend)
	{
		table2 = $('#listCompare2').DataTable({
			"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
			"paging": false,
			//processing: true,
            serverSide: true,
            "autoWidth": false,
            "ajax":{
            	url: url_compare2,
            	type: "POST",
            	data: {
            		"timestart": timestart,
            		"timeend": timeend
            	}
            },
		});
	}

	function loadListTransactionCompare3(timestart,timeend)
	{
		table3 = $('#listCompare3').DataTable({
			"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
			"paging": false,
			//processing: true,
            serverSide: true,
            "autoWidth": false,
            "ajax":{
            	url: url_compare3,
            	type: "POST",
            	data: {
            		"timestart": timestart,
            		"timeend": timeend
            	}
            },
		});
	}

	$("#excel_file").change(function(){
        var allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)) {
            jQuery("#chk-error").html('<small class="text-danger">Please choose a valid file (XLS,XLSX)</small>');
            $("#excel_file").val('');
            return false;
        } else {
          jQuery("#chk-error").html('');
        }
    });
});