<style>
#calendar {
		width: 700px;
		margin: 0 auto;
	}

	.response {
		height:0px;
	}

	.success {
		background: #cdf3cd;
		padding: 10px 60px;
		border: #c3e6c3 1px solid;
		display: inline-block;
	}
	thead th {
		background: #f1c152;
		color:#fff;
		height: 25px!important;
		vertical-align: middle!important;
	}

	.fc-day {
		background: #f5f5f5;
	}
	.fc-day-header {
		background-color: #f1c152 !important;
		background-image: none;
		line-height: 40px;
		color: #fff;
		font-family: 'existencelight';
		font-size: 18px;
		text-shadow: 1px 1px 1px #333;
	}
	.fc button {
		background: #f1c152;
		color: #fff;
	}
	.fc-toolbar h2 {
		margin: 0;
		line-height: 35px;
		font-family: Roboto;
		font-size: 30px;
    	text-transform: uppercase;
	}
	.fc-event, .fc-event-dot {
		background-color: #2e3192;
	}
	.fc-event {
		border: 1px solid #2e3192;
	}
</style>



<div class="pageheader" style="">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="    text-align: center;">
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Events</h2>
			</div>
		</div>
	</div>
</div>
<div class="contact padding--top padding--bottom" style="padding: 40px 0 100px 0;background:#ffffff">
	<div class="container">  
		<div class="row">
			<!--<div class="col-sm-7">
				<div class="response"></div>
				<div id='calendar' style="width:100%"></div>
			</div>
			<div class="col-sm-5">
				<div id="display_leave_summary_list"></div>
			</div>-->
            <div class="monthly" id="mycalendar"></div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
	</div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/monthly.css">
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/website/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/website/monthly.js"></script>

<?php 
$curyear = date("Y");
$curmonth = date("m");
?>
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/fullcalendar/fullcalendar.min.css" />
<script src="<?php echo base_url(); ?>/assets/website/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/website/fullcalendar/fullcalendar.min.js"></script>
<script>
prev_nextMonth(<?php echo $curyear; ?>,<?php echo $curmonth; ?>);
$(document).ready(function () {
	$('body').on('click', '.fc-prev-button', function() {
		var prevDate = $("#calendar").fullCalendar('getDate').toDate();
		//var month = prevDate.toLocaleString('default', { month: 'long' });
		var year = prevDate.getFullYear();
		var month = prevDate.getMonth() + 1;
		//var yrmn = year+'-'+month;
		prev_nextMonth(year,month);
	});

	$('body').on('click', '.fc-next-button', function() {
		var nextDate = $("#calendar").fullCalendar('getDate').toDate();
		var year = nextDate.getFullYear();
		var month = nextDate.getMonth() + 1;
		//var yrmn = year+'-'+month;
		prev_nextMonth(year,month);
	});
});

function prev_nextMonth(yr,mnth)
{
	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>/online_event/getEventSummary',
		data: {year: yr, month:mnth},
		//dataType: "JSON",
		success: function(data) {
			$("#display_leave_summary_list").html(data);
		}
	});
}

$(document).ready(function () {
	var arlene2 = true;
    var calendar = $('#calendar').fullCalendar({
		header: {
			left: '',
			center: 'prev title next',
			right: ''
		},
	
    events: {
			url: '<?php echo base_url(); ?>/online_event/fetch_events',
			type: 'POST',
			cache: true,
		},
        displayEventTime: false,
        eventRender: function (event, element, view) {
			//alert(event.leave_type);
			var el = element.html();
			element.html("<div style='width:100%;text-transform:uppercase'>"+event.title_tamil+"</div>"); 
			
			if(event.status == "1")
			{
				element.css({
					'background-color': '#0000FF',
					'border-color': '#0000FF',
					'color':'#fff',
					'text-align':'center',
					'display':'block'
				});
			}
      if (event.allDay === 'true') {
          event.allDay = true;
      } else {
          event.allDay = false;
      }
			//alert(arlene2);
        },
        selectable: false,
        selectHelper: false,
		//nextDayThreshold:'00:00',
        select: function (start, end, allDay) { },
    });
});
</script>-->

<script type="text/javascript">
	
	var sampleEvents = {
	"monthly": [
		{
		"id": 1,
		"name": "Whole month event",
		"startdate": "2023-10-01",
		"starttime": "12:00",
		"endtime": "2:00",
		"color": "#99CCCC",
		"url": ""
		},
		{
		"id": 2,
		"name": "Test encompasses month",
		"startdate": "2023-10-29",
		"starttime": "12:00",
		"endtime": "2:00",
		"color": "#CC99CC",
		"url": ""
		},
		{
		"id": 3,
		"name": "Test single day",
		"startdate": "2024-06-04",
		"starttime": "",
		"endtime": "",
		"color": "#666699",
		"url": "https://www.google.com/"
		},
		{
		"id": 8,
		"name": "Test single day",
		"startdate": "2024-06-05",
		"starttime": "",
		"endtime": "",
		"color": "#666699",
		"url": "https://www.google.com/"
		},
		{
		"id": 4,
		"name": "Test single day with time",
		"startdate": "2024-06-07",
		"starttime": "12:00",
		"endtime": "02:00",
		"color": "#996666",
		"url": ""
		},
		{
		"id": 5,
		"name": "Test splits month",
		"startdate": "2024-06-25",
		"starttime": "",
		"endtime": "",
		"color": "#999999",
		"url": ""
		},
		{
		"id": 6,
		"name": "Test events on same day",
		"startdate": "2024-06-25",
		"starttime": "",
		"endtime": "",
		"color": "#99CC99",
		"url": ""
		},
		{
		"id": 7,
		"name": "Test events on same day",
		"startdate": "2024-06-25",
		"starttime": "",
		"endtime": "",
		"color": "#669966",
		"url": ""
		},
		{
		"id": 9,
		"name": "Test events on same day",
		"startdate": "2024-06-25",
		"starttime": "",
		"endtime": "",
		"color": "#999966",
		"url": ""
		}
	]
	};

	$(window).load( function() {
		$('#mycalendar').monthly({
			mode: 'event',
			dataType: 'json',
			events: sampleEvents
		});
	});
</script>