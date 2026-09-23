<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

    <!-- Mobiscroll JS and CSS Includes -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/calendar/mobiscroll.jquery.min.css">
    <script src="<?php echo base_url(); ?>/assets/website/calendar/mobiscroll.jquery.min.js"></script>

<style>
        .md-tooltip .mbsc-popup-content {
        padding: 0;
    }
    
    .md-tooltip {
        font-size: 15px;
        font-weight: 600;
    }
    
    .md-tooltip-header {
        padding: 12px 16px;
        color: #eee;
    }
    
    .md-tooltip-info {
        padding: 16px 16px 60px 16px;
        position: relative;
        line-height: 32px;
    }
    
    .md-tooltip-time,
    .md-tooltip-status-button {
        float: right;
    }
    
    .md-tooltip-title {
        margin-bottom: 15px;
    }
    
    .md-tooltip-text {
        font-weight: 300;
    }
    
    .md-tooltip-info .mbsc-button {
        font-size: 14px;
        margin: 0;
    }
    
    .md-tooltip-info .mbsc-button.mbsc-material {
        font-size: 12px;
    }
    
    .md-tooltip-view-button {
        position: absolute;
        bottom: 16px;
        left: 16px;
    }
    
    .md-tooltip-delete-button {
        position: absolute;
        bottom: 16px;
        right: 16px;
    }
	.mbsc-ios.mbsc-eventcalendar .mbsc-calendar-header, .mbsc-ios.mbsc-eventcalendar .mbsc-calendar-week-days {
    background: #7e4555;
}
.mbsc-calendar-week-days { background: #e2808c !important; }
.mbsc-ios.mbsc-calendar-button.mbsc-button {
    color: #eeeeee;
}
.mbsc-ios.mbsc-calendar-label-end.mbsc-rtl .mbsc-calendar-label-background, .mbsc-ios.mbsc-calendar-label-start.mbsc-ltr .mbsc-calendar-label-background {
     border-bottom-left-radius: 0em !important; 
     border-top-left-radius: 0em !important; 
    margin-left: 0;
    border-left: 3px solid #7e4555;
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
			<div mbsc-page class="demo-custom-event-tooltip">
        <div style="height:100%">
                <div id="custom-event-tooltip-popup" class="md-tooltip">
        <div id="tooltip-event-header" class="md-tooltip-header">
            <span id="tooltip-event-name-age" class="md-tooltip-name-age"></span>
            <span id="tooltip-event-time" class="md-tooltip-time"></span>
        </div>
        <div class="md-tooltip-info">
            <div id="tooltip-event-title" class="md-tooltip-title">
                Status: <span class="md-tooltip-status md-tooltip-text"></span>
                <!--<button id="tooltip-event-status" mbsc-button data-color="warning" data-variant="outline" class="md-tooltip-status-button"></button>-->
            </div>
            <!--<div id="tooltip-event-reason" class="md-tooltip-title">Reason for visit: <span class="md-tooltip-reason md-tooltip-text"></span></div>-->
            <div id="tooltip-event-location" class="md-tooltip-title">Location: <span class="md-tooltip-location md-tooltip-text"></span></div>
            <!--<button id="tooltip-event-view" mbsc-button data-color="secondary" class="md-tooltip-view-button">View patient file</button>
            <button id="tooltip-event-delete" mbsc-button data-color="danger" data-variant="outline" class="md-tooltip-delete-button">Delete appointment</button>-->
        </div>
    </div>
    <div id="demo-custom-event-tooltip"></div>
      
        </div>
    </div>

    

    
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
	</div>
</div>


<?php 
$curyear = date("Y");
$curmonth = date("m");
?>
<script>
        
            mobiscroll.setOptions({
      locale: mobiscroll.localeEn,           // Specify language like: locale: mobiscroll.localePl or omit setting to use default
      theme: 'ios',                          // Specify theme like: theme: 'ios' or omit setting to use default
            themeVariant: 'light'            // More info about themeVariant: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-themeVariant
    });
    
    $(function () {
      var formatDate = mobiscroll.formatDate;
      var currentEvent;
      var timer;
      var $tooltip = $('#custom-event-tooltip-popup');
      var $deleteButton = $('#tooltip-event-delete');
      var $fileButton = $('#tooltip-event-view');
      var $statusButton = $('#tooltip-event-status');
      var $header = $('.md-tooltip-header');
      var $data = $('.md-tooltip-name-age');
      var $time = $('.md-tooltip-time');
      var $status = $('.md-tooltip-status');
      var $reason = $('.md-tooltip-reason');
      var $location = $('.md-tooltip-location');
    
      var calendar = $('#demo-custom-event-tooltip')
        .mobiscroll()
        .eventcalendar({
          
          view: {                // More info about view: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-view
            calendar: {
              type: 'month',
            },
          },
          //height: 260,                       // More info about height: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-height
          data: [                            // More info about data: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-data
            {
              title: 'Jude Chester',
              age: 69,
              start: '2024-05-20T08:00',
              end: '2024-05-20T09:00',
              confirmed: false,
              reason: 'Headaches morning & afternoon',
              location: 'Topmed, Building A, Room 203',
              color: '#b33d3d',
            },
            {
              title: 'Leon Porter',
              age: 44,
              start: '2024-05-20T09:00',
              end: '2024-05-20T10:00',
              confirmed: false,
              reason: 'Left abdominal pain',
              location: 'Topmed, Building D, Room 360',
              color: '#b33d3d',
            },
            {
              title: 'Lily Racquel',
              age: 54,
              start: '2024-05-20T10:00',
              end: '2024-05-20T11:00',
              confirmed: true,
              reason: 'Dry, persistent cough & headache',
              location: 'Procare, Building C, Room 12',
              color: '#309346',
            },
            {
              title: 'Mia Sawyer',
              age: 59,
              start: '2024-05-20T11:00',
              end: '2024-05-20T12:00',
              confirmed: true,
              reason: 'Difficulty sleeping & loss of appetite',
              location: 'Procare, Building C, Room 12',
              color: '#309346',
            },
            {
              title: 'Jon Candace',
              age: 63,
              start: '2024-05-20T12:00',
              end: '2024-05-20T13:00',
              confirmed: true,
              reason: 'Nausea & weakness',
              location: 'MedStar, Building A, Room 1',
              color: '#c77c0a',
            },
            {
              title: 'Layton Drake',
              age: 57,
              start: '2024-05-20T13:00',
              end: '2024-05-20T14:00',
              confirmed: true,
              reason: 'Headaches & loss of appetite',
              location: 'Vitalife, Room 160',
              color: '#c77c0a',
            },
            {
              title: 'Willis Kane',
              age: 44,
              start: '2024-05-21T08:00',
              end: '2024-05-21T09:00',
              confirmed: true,
              reason: 'Back pain',
              location: 'Care Cente, Room 320r',
              color: '#b33d3d',
            },
            {
              title: 'Theo Calanthia',
              age: 60,
              start: '2024-05-21T09:00',
              end: '2024-05-21T10:00',
              confirmed: true,
              reason: 'Anxiousness & sleeping disorder',
              location: 'Care Center, Room 320',
              color: '#b33d3d',
            },
            {
              title: 'Ford Kaiden',
              age: 53,
              start: '2024-05-21T14:00',
              end: '2024-05-21T15:00',
              confirmed: true,
              reason: 'Nausea & vomiting',
              location: 'Care Center, Room 206',
              color: '#b33d3d',
            },
            {
              title: 'Gerry Irma',
              age: 50,
              start: '2024-05-21T13:00',
              end: '2024-05-21T14:00',
              confirmed: false,
              reason: 'Fever & sore throat',
              location: 'Medica Zone, Building C, Room 2',
              color: '#c77c0a',
            },
            {
              title: 'Carlyn Dorothy',
              age: 36,
              start: '2024-05-21T14:00',
              end: '2024-05-21T15:00',
              confirmed: true,
              reason: 'Tiredness & muscle pain',
              location: 'Medica Zone, Building C, Room 2',
              color: '#c77c0a',
            },
            {
              title: 'Alma Potter',
              age: 74,
              start: '2024-05-19T10:00',
              end: '2024-05-19T11:00',
              confirmed: true,
              reason: 'High blood pressure',
              location: 'Vitacure, Building D, Room 2',
              color: '#b33d3d',
            },
            {
              title: 'Debra Aguilar',
              age: 47,
              start: '2024-05-19T11:00',
              end: '2024-05-19T12:00',
              confirmed: false,
              reason: 'Fever & sore throat',
              location: 'Vitacure, Building D, Room 2',
              color: '#b33d3d',
            },
            {
              title: 'Marjorie White',
              age: 55,
              start: '2024-05-19T13:00',
              end: '2024-05-19T14:00',
              confirmed: true,
              reason: 'Back pain',
              location: 'Vitacure, Building D, Room 2',
              color: '#b33d3d',
            },
            {
              title: 'Lora Wilson',
              age: 66,
              start: '2024-05-19T15:00',
              end: '2024-05-19T16:00',
              confirmed: false,
              reason: 'Fever & headache',
              location: 'Vitacure, Building D, Room 2',
              color: '#b33d3d',
            },
            {
              title: 'Christie Baker',
              age: 71,
              start: '2024-05-19T10:00',
              end: '2024-05-19T11:00',
              confirmed: true,
              reason: 'Headaches morning & afternoon',
              location: 'Care Center, Room 300',
              color: '#309346',
            },
            {
              title: 'Arlene Lyons',
              age: 41,
              start: '2024-05-19T14:00',
              end: '2024-05-19T15:00',
              confirmed: true,
              reason: 'Nausea & weakness',
              location: 'Care Center, Room 202',
              color: '#c77c0a',
            },
            {
              title: 'Dory Edie',
              age: 45,
              start: '2024-05-18T09:00',
              end: '2024-05-18T10:00',
              confirmed: true,
              reason: 'Right abdominal pain',
              location: 'Vitacure, Building A, Room 203',
              color: '#309346',
            },
            {
              title: 'Kaylin Toni',
              age: 68,
              start: '2024-05-18T10:00',
              end: '2024-05-18T11:00',
              confirmed: true,
              reason: 'Itchy, red rashes',
              location: 'Vitacure, Building A, Room 203',
              color: '#309346',
            },
            {
              title: 'Gray Kestrel',
              age: 60,
              start: '2024-05-18T12:00',
              end: '2024-05-18T13:00',
              confirmed: true,
              reason: 'Cough & fever',
              location: 'Vitacure, Building A, Room 203',
              color: '#309346',
            },
            {
              title: 'Lou Andie',
              age: 76,
              start: '2024-05-18T15:00',
              end: '2024-05-18T16:00',
              confirmed: true,
              reason: 'High blood pressure',
              location: 'Medica Zone, Room 13',
              color: '#309346',
            },
            {
              title: 'Yancy Dustin',
              age: 52,
              start: '2024-05-18T10:00',
              end: '2024-05-18T11:00',
              confirmed: true,
              reason: 'Fever & headache',
              location: 'Vitacure, Building E, Room 50',
              color: '#c77c0a',
            },
            {
              title: 'Terry Clark',
              age: 78,
              start: '2024-05-18T11:00',
              end: '2024-05-18T12:00',
              confirmed: true,
              reason: 'Swollen ankles',
              location: 'Vitacure, Building E, Room 50',
              color: '#c77c0a',
            },
          ],
          clickToCreate: false,              // More info about clickToCreate: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-clickToCreate
          dragToCreate: false,               // More info about dragToCreate: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-dragToCreate
          dragToMove: false,                  // More info about dragToMove: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-dragToMove
          dragToResize: false,               // More info about dragToResize: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-dragToResize
          showEventTooltip: false,           // More info about showEventTooltip: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-showEventTooltip
          onEventHoverIn: function (args) {  // More info about onEventHoverIn: https://mobiscroll.com/docs/jquery/eventcalendar/api#event-onEventHoverIn
            var event = args.event;
            var time = formatDate('hh:mm A', new Date(event.start)) + ' - ' + formatDate('hh:mm A', new Date(event.end));
            var button = {};
    
            currentEvent = event;
    
            if (event.confirmed) {
              button.status = 'Confirmed';
              button.text = 'Cancel appointment';
              button.type = 'warning';
            } else {
              button.status = 'Canceled';
              button.text = 'Confirm appointment';
              button.type = 'success';
            }
    
            $header.css('background-color', event.color);
            //$data.text(event.title + ', Age: ' + event.age);
			$data.text(event.title);
            $time.text(time);
    
            $status.text(button.status);
            $reason.text(event.reason);
            $location.text(event.location);
    
            $statusButton.text(button.text);
            $statusButton.mobiscroll('setOptions', { color: button.type });
    
            clearTimeout(timer);
            timer = null;
    
            tooltip.setOptions({ anchor: args.domEvent.target });
            tooltip.open();
          },
          onEventHoverOut: function () {     // More info about onEventHoverOut: https://mobiscroll.com/docs/jquery/eventcalendar/api#event-onEventHoverOut
            if (!timer) {
              timer = setTimeout(function () {
                tooltip.close();
              }, 200);
            }
          },
        })
        .mobiscroll('getInst');
    
      var tooltip = $tooltip
        .mobiscroll()
        .popup({
          display: 'anchored',               // Specify display mode like: display: 'bottom' or omit setting to use default
          touchUi: false,
          showOverlay: false,
          contentPadding: false,
          width: 350,                        // More info about width: https://mobiscroll.com/docs/jquery/eventcalendar/api#opt-width
        })
        .mobiscroll('getInst');
    
      $tooltip.mouseenter(function () {
        if (timer) {
          clearTimeout(timer);
          timer = null;
        }
      });
    
      $tooltip.mouseleave(function () {
        timer = setTimeout(function () {
          tooltip.close();
        }, 200);
      });
    
      $deleteButton.on('click', function () {
        calendar.removeEvent(currentEvent);
    
        tooltip.close();
    
        mobiscroll.toast({

          message: 'Appointment deleted',
        });
      });
    
      $fileButton.on('click', function () {
        tooltip.close();
    
        mobiscroll.toast({

          message: 'View file',
        });
      });
    
      $statusButton.on('click', function () {
        tooltip.close();
        currentEvent.confirmed = !currentEvent.confirmed;
        calendar.updateEvent(currentEvent);
    
        mobiscroll.toast({

          message: 'Appointment ' + (currentEvent.confirmed ? 'confirmed' : 'canceled'),
        });
      });
    });
      
    </script>