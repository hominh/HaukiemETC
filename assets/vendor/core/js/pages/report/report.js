$(document).ready(function () {
	initDateTime();
	function initDateTime() {
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var now = d.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;

		$("#timestart").val(now + " 00:00:00");
		$("#timeend").val(now + " 23:59:59");

		$("#day").val(day);
		$("#year").val(d.getFullYear());

		for(var i = 1; i <= 12; i++)
		{
			$("#month").append($("<option></option>")
                .attr("value", i)
                .text(i));
		}
		$("#month").val(month);
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
	$("#generateReport").click(function(e){
		e.preventDefault();
		var timestart = $('input[name=timestart]').val();
		var timeend = $('input[name=timeend]').val();
		var ca = $("#ca").val();
		var day = $("#day").val();
		var month = $("#month").val();
		if(month < 10)
			month = "0" + month;
		if(day < 10)
			day = "0" + day;
		var year = $("#year").val();
		var report = $('#report:checked').val();
		if(report == 0 || report == 4)
		{
			if (!day.trim()) {
				toastr.error("Chưa nhập ngày");
				return;
			}
		}


		$.ajax({
			type: "POST",
			url: url_generate_report,
			data:{
				'timestart': timestart,
				'timeend': timeend,
				'ca': ca,
				'day': day,
				'month': month,
				'year': year,
				'report': report,
			},
			success: function(data) {
				console.log(data);
			}
		});
	});

});