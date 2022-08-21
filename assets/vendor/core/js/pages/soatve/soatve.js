$(document).ready(function () {
	var timeSoatve = "";
	var isNextVideo = 0;
	initDateTime();
	loadSoatve();
	var table;
	function loadSoatve()
	{
		//$('#plate').val("");
		var tickettypevetc = 0;
		var strCheckBox = "";
		$('input:checkbox[name=tickettype]').each(function()
		{
		    if($(this).is(':checked'))
		    {
				if(strCheckBox != "")
					strCheckBox+= ",";
				strCheckBox+= $(this).val();
		    }
		});

		var freec = 0;
		if($('#freec').is(":checked"))
			freec = 1;

		var freedc = 0;
		if($('#freedc').is(":checked"))
			freedc = 1;

		var isMoney = 3;

		if($('#etcday').is(":checked") || $('#etcmonth').is(":checked") || $('#etcmpkv').is(":checked") || $('#etcmienphi').is(":checked") || $('#etcoffline').is(":checked"))
		{
			if($('#nomoney').is(":checked") && $('#hasmoney').is(":checked") == false)
				isMoney = 0;
    		if($('#hasmoney').is(":checked") && $('#nomoney').is(":checked") == false)
    			isMoney = 1;
    		if($('#hasmoney').is(":checked") && $('#nomoney').is(":checked"))
    			isMoney = 3;
    		if($('#hasmoney').is(":checked") == false && $('#nomoney').is(":checked") == false)
    			isMoney = 3;

    		if($('select[name=tickettypevetc]').val() == 0)
    			tickettypevetc = 0;
    		if($('select[name=tickettypevetc]').val() == 1)
    			tickettypevetc = 1;
    		if($('select[name=tickettypevetc]').val() == 2)
    			tickettypevetc = 5;
		}

		table = $('#listSoatve').DataTable({
			"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
    		"paging": true,
    		"pageLength": 8,
            processing: true,
            serverSide: true,
            "autoWidth": false,
            keys: true,
            select: true,
            order: [[1, 'desc']],
            'columnDefs' : [
    			{ 'visible': false, 'targets': [11,12,13] }
			],
			"ajax":{
				url: url_listsoatve,
				type: "POST",
				data: {
					//"_token": "{{ csrf_token() }}",
					'timestart': $('input[name=timestart]').val(),
					'timeend': $('input[name=timeend]').val(),
					'plate':$('input[name=plate]').val(),
					'barcode':$('input[name=barcode]').val(),
					'employee': $('select[name=employee]').val(),
					'lane': $('select[name=lane]').val(),
					'cartype': $('select[name=cartype]').val(),
					'platetype': $('select[name=platetype]').val(),
					'transactiontype': $('select[name=transactiontype]').val(),
					'tickettype': strCheckBox,
					'freec': freec,
					'freedc': freedc,
					'isMoney': isMoney,
					'tickettypevetc': tickettypevetc
				}
			},
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull 
            	) {
				var etagplate = '';
				if(aData[4] != null)
				{
					if(aData[4].substr(aData[4].length - 1) == 'T' || aData[4].substr(aData[4].length - 1) == 'V' || aData[4].substr(aData[4].length - 1) == 'X')
        				etagplate = aData[4].substring(0, aData[4].length - 1);
				}
				else
					etagplate = aData[4];
				if(aData[6] != null && (aData[3] == '' || aData[3] != etagplate))
					$('td', nRow).css('background-color', 'Yellow');
			},
			initComplete: function() {
		 			var count = $('#listSoatve tr td').length;
		 			if(count > 1)
		 				$("#listSoatve").find("tbody tr:eq(0)").trigger("click");
				}
		});
	}

	function loadDataSoatve(data)
	{
		$('#plate_old').val();
		$("#image_lane").attr("src", data[11]);
	    $("#image_bienso").attr("src", data[12]);
	    //$('#plate').val(data[3]);
	    $('#changetransaction_plate').val(data[3]);
	    $('#changetransaction_etag').val(data[13]);
	    $('#changetransaction_ticketid').val(data[5]);
	    $('#changetransaction_type').val(data[6]);
	    $('#soatve_id').val(data[0]);
	    $('#plate_old').val(data[3]);
	    timeSoatve = data[1];
	    if(data[6] == 'Commit')
			$("#commitbutton").prop("disabled",true);
		else
			$("#commitbutton").prop("disabled",false);

		if(data[5] == "" || data[13] == "" || data[7].indexOf("MTC") != -1)
    	{
    		$("#commitbutton").prop("disabled",true);
    		$("#lockbutton").prop("disabled",true);
    	}


	    $.ajax({
	    	type: "POST",
	    	url: url_getvehiclebyplate,
	    	data: {
	    		'plate': data[3]
	    	},
	    	success: function(data) {
	    		data = JSON.parse(data);
	    		if(data.length > 0)
	    		{
	    			$("#trueplate").val(data[0]["xe_bienso"]);
	    			$("#employeesavetruevehicle").val(data[0]["nsd_ten"]);
	    			$("#datesavetruevehicle").val(data[0]["xe_ngaynhap"]);
	    			$("#truevehicletype").val(data[0]["xe_loaixe"]);
	    			$("#notetruevehicle").val(data[0]["xe_ghichu"]);
	    			if(data[0]["xe_canhbao"] == 1)
	    				$( "#isWarning").attr("checked", "checked");
	    			else
	    				$( "#isWarning").removeAttr('checked');

	    		}
	    		else{
	    			$("#trueplate").val("");
	    			$("#employeesavetruevehicle").val("");
	    			$("#datesavetruevehicle").val("");
	    			$("#notetruevehicle").val("");
	    			$("#truevehicletype").val(0);
	    			$( "#isWarning").removeAttr('checked');
	    		}
	    	}
	    });
	    var tableHistory = $('#listHistory').DataTable({
	    	"destroy": true,
			"bInfo" : true,
			"bLengthChange": false,
			"searching": false,
    		"paging": false,
            processing: true,
            serverSide: true,
            "autoWidth": false,
            selected: true,
            page: 'current',
			"ajax":{
				url: url_getListByPlate,
				type: "POST",
				data: {
					'plate':data[3],
				}
			},
	    });
	}

	$('#listSoatve tbody').on( 'click', 'tr', function () {
		var currentRow = $(this).closest("tr");
	    var data = table.row(currentRow).data();
		console.log(data);
	    loadDataSoatve(data);
	});

	table.on('key-focus', function(e, datatable, cell, originalEvent) {
		if (originalEvent.type === 'keydown') {
      		table.rows().deselect();
      		table.row(cell[0][0].row).select();
      		loadDataSoatve(table.row(cell[0][0].row).data());
    	}
	});

	function loadVideo()
	{
		var table = $('#listVideo').DataTable({
			"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
    		"paging": true,
    		"pageLength": 18,
            processing: true,
            serverSide: true,
            "autoWidth": false,
            order: [[2, 'desc']],
            'columnDefs' : [
    			{ 'visible': false, 'targets': [3] }
			],
			"ajax":{
				url: url_videofilter,
				type: "POST",
				data: {
					'fromtime': $('#timestartVideo').val(),
					'totime': $('#timeendVideo').val(),
					'camera':$('select[name=camera]').val(),
				}
			},
		});
	}

	$("#timestartVideo").change( function() {
		loadVideo();
	});
	$("#timeendVideo").change( function() {
		loadVideo();
	});

	$('#camera').on('change', function (e) {
		loadVideo();
	});

	$("#btnSearch").click(function(e) {
    	loadSoatve();
	});

	$("#btnUpdateTrueVehicle").click(function(e){
		var isWarning = 0;
		if($("#trueplate").val() == "")
		{
			toastr.error("Cần nhập biển số");
			return;
		}
		if ($('#isWarning').is(':checked')) {
			isWarning = 1;
		}
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: url_vehicleupdate,
			data: {
				'xe_bienso': $("#trueplate").val(),
				'xe_loaixe': $("#truevehicletype").val(),
				'xe_canhbao': isWarning,
				"xe_ghichu": $("#notetruevehicle").val()
			},
			success: function(data) {
				if(data == "1")
					toastr.info("Cập nhật xe chuẩn thành công");
				else
					toastr.error("Cập nhật xe chuẩn thất bại");
			}
		});
	});

	$("#commitbutton").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: url_changecommittype,
			data:{
				'vetctransaction_ticketid': $('#changetransaction_ticketid').val()
			},
    		success: function(data) {
    			if(data == "1")
    				toastr.info("Chuyển đổi giao dịch thành công");
    			else
    				toastr.error("Chuyển đổi giao dịch thất bại");
    		}
		});
		loadSoatve();
	});

	$("#lockbutton").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: url_locktransaction,
			data:{
				'vetctransaction_ticketid': $('#changetransaction_ticketid').val()
			},
    		success: function(data) {
    			if(data == "1")
    				toastr.info("Khóa giao dịch thành công");
    			else
    				toastr.error("Khóa giao dịch thất bại");
    		}
		});
		loadSoatve();
	});

	$("#btnUpdatePlate").click(function(e){
		e.preventDefault();
		if(!$('#plate').val().trim()) {
			toastr.error("Biển số trống");
			return;
		}
		if(!$('#soatve_id').val().trim())
		{
			toastr.error("Error id soatve");
			return;
		}
		$.ajax({
			type: "POST",
			url: url_updateplate,
			data:{
				'soatve_id': $('#soatve_id').val(),
				'plate': $('#plate').val(),
				'plate_old': $('#plate_old').val()
			},
    		success: function(data) {
    			if(data == "1")
    				toastr.info("Cập nhật biển số thành công");
    			else
    				toastr.error("Cập nhật biển số thất bại");
    		}
		});
		$('#plate').val("");
		loadSoatve();
	});
	$("#btnExport").click(function(e){
		$('.dataTables_processing').hide();
		$('.dataTables_processing').show();
		var tickettypevetc = 0;
		var strCheckBox = "";
		$('input:checkbox[name=tickettype]').each(function()
		{
		    if($(this).is(':checked'))
		    {
				if(strCheckBox != "")
					strCheckBox+= ",";
				strCheckBox+= $(this).val();
		    }
		});

		var freec = 0;
		if($('#freec').is(":checked"))
			freec = 1;

		var freedc = 0;
		if($('#freedc').is(":checked"))
			freedc = 1;

		var isMoney = 3;

		if($('#etcday').is(":checked") || $('#etcmonth').is(":checked") || $('#etcmpkv').is(":checked") || $('#etcmienphi').is(":checked") || $('#etcoffline').is(":checked"))
		{
			if($('#nomoney').is(":checked") && $('#hasmoney').is(":checked") == false)
				isMoney = 0;
    		if($('#hasmoney').is(":checked") && $('#nomoney').is(":checked") == false)
    			isMoney = 1;
    		if($('#hasmoney').is(":checked") && $('#nomoney').is(":checked"))
    			isMoney = 3;
    		if($('#hasmoney').is(":checked") == false && $('#nomoney').is(":checked") == false)
    			isMoney = 3;

    		if($('select[name=tickettypevetc]').val() == 0)
    			tickettypevetc = 0;
    		if($('select[name=tickettypevetc]').val() == 1)
    			tickettypevetc = 1;
    		if($('select[name=tickettypevetc]').val() == 2)
    			tickettypevetc = 5;
		}
		$.ajax({
			type: "POST",
			url: url_export_excel,
			data: {
				'timestart': $('input[name=timestart]').val(),
				'timeend': $('input[name=timeend]').val(),
				'plate':$('input[name=plate]').val(),
				'barcode':$('input[name=barcode]').val(),
				'employee': $('select[name=employee]').val(),
				'lane': $('select[name=lane]').val(),
				'cartype': $('select[name=cartype]').val(),
				'platetype': $('select[name=platetype]').val(),
				'transactiontype': $('select[name=transactiontype]').val(),
				'tickettype': strCheckBox,
				'freec': freec,
				'freedc': freedc,
				'isMoney': isMoney,
				'tickettypevetc': tickettypevetc
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

	function initDateTime()
	{
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var now = d.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;

		$("#timestart").val(now + " 00:00:00");
		$("#timeend").val(now + " 23:59:59");
		$("#timestartVideo").val(now + " 00:00:00");
		$("#timeendVideo").val(now + " 23:59:59");

		$('.form_datetime').datetimepicker({
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	    })
	}

	//var vid = document.getElementById("#videoView");
	var indexDownSpeed = indexUpSpeed = parseFloat(2);
	var currentSpeed = 1;
	var currentRowVideo = 0;
	$("#btnPlayback").click(function(e){

		$('#modalPlayback').modal('show');
		showClock();
		indexDownSpeed = indexUpSpeed = parseFloat(2);
		currentSpeed = 1;

	    var tableListVideo = $('#listVideo').DataTable({
	    	"destroy": true,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": false,
    		"paging": true,
    		"pageLength": 18,
            processing: true,
            serverSide: true,
            "autoWidth": false,
            order: [[2, 'desc']],
            'columnDefs' : [
    			{ 'visible': false, 'targets': [3] }
			],
			"ajax":{
				url: url_getlistvideobytime,
				type: "POST",
				data: {
					'video_thoigian': timeSoatve
				}
			},
			initComplete: function() {
		 			var count = $('#listVideo tr td').length;
		 			if(count > 1)
		 			{
		 				$("#listVideo").find("tbody tr:eq(0)").trigger("click");
		 			}
				}
	    });
	});
	
	$("body").on("click", "#listVideo tr", function () {
		$("#listVideo tbody tr").removeClass('row_selected');
		$(this).addClass('row_selected');
		var currentRow = $(this).closest("tr");
		currentRowVideo = currentRow.index();
	    var data = $('#listVideo').DataTable().row(currentRow).data();
	    $('#videoView').attr('src', data[3]);
	    $("#videoView")[0].load();
	});

	$("#playVideo").click(function(e){
		$("#videoView").trigger('play');
		$(this).prop('disabled', true);
	});

	$("#pauseVideo").click(function(e){
		$("#videoView").trigger('pause');
		$('#playVideo').prop('disabled', false);
	});

	$("#nextVideo").click(function(e){
		nextVideo();
	});

	$("#prevVideo").click(function(e){
		var strPrevVideo = "tbody tr:eq(";
		strPrevVideo += parseInt(currentRowVideo) - 1;
		strPrevVideo += ")";
		$("#listVideo").find(strPrevVideo).trigger("click");
	});

	function nextVideo()
	{
		var strNextVideo = "tbody tr:eq(";
		strNextVideo += parseInt(currentRowVideo) + 1;
		strNextVideo += ")";
		$("#listVideo").find(strNextVideo).trigger("click");
	}

	$("#speedDownVideo").click(function(e){
		currentSpeed = parseFloat(currentSpeed / indexDownSpeed);
		if(currentSpeed <= parseFloat(0.03125))
			currentSpeed = parseFloat(0.03125);
		document.querySelector('video').playbackRate = parseFloat(currentSpeed);
	});
	$("#speedUpVideo").click(function(e){
		currentSpeed = parseFloat(currentSpeed * indexUpSpeed);
		if(currentSpeed >= 32)
			currentSpeed = 16;
		document.querySelector('video').playbackRate = parseFloat(currentSpeed);
	});
	function showClock(hour,minute,second)
	{
		hour = parseInt(hour);
		minute = parseInt(minute);
		second = parseInt(second);
		var clock = hour + ":" + minute + ":" + second;
		$("#time").html(clock);
	}

	$('#videoView').on('ended',function(){
		if ($('#isNextVideo').is(':checked')) {
			nextVideo();
		}
	});

});