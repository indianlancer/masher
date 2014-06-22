// Init vars
var closedBoxesCookiePrefix = "SimplensoClosedBoxes_";
var boxPositionCookiePrefix = "SimplensoColumnBoxes_";
var deletedBoxesCookiePrefix = "SimplensoDeletedBoxes_";
var themeCookie = "SimplensoTheme";
var menuCookie = "SimplensoMenu";
var cookieExpiration = 365;

var screenWidth = $(document).width();
var screenHeigth =  $(document).height();

// Load google chart script
google.load('visualization', '1', {packages: ['geochart']});
google.load("visualization", "1", {packages:["corechart"]});
google.load('visualization', '1', {packages:['gauge']});

/* index.html specific script */
$(document).ready(function(){	
	if($("body").attr("id") == "dashboard") {
		// Geo Map Chart
		var mapWidth = Math.round(((screenWidth / 12) * 10) * 0.8);
		var mapHeight = Math.round(mapWidth * 0.5);

		$('#dashboard-visit-map').width(mapWidth*1.1);
		$('#dashboard-visit-map').height(mapHeight*1.1);

		var data = google.visualization.arrayToDataTable([
		  ['Country', 'Page Hits'],
		  ['Germany', 3000],
		  ['United States', 4500],
		  ['Brazil', 11000],
		  ['Canada', 9000],
		  ['France', 14000],
		  ['RU', 8700],
		  ['NL', 20000]
		]);
	  
		var geochart = new google.visualization.GeoChart(
			document.getElementById('dashboard-visit-map'));
		geochart.draw(data, {width: mapWidth, height: mapHeight,backgroundColor: { fill:'transparent' }});
		  
		// Pie Chart
		var data = google.visualization.arrayToDataTable([
			['Browser', 'Usage'],
			['Internet Explorer', 11],
			['Google Chrome', 2],
			['Opera',  2],
			['Safari', 2],
			['FireFox', 7]
		  ]);

		  var options = {
			title: 'Browser Usage',
		    forceIFrame: false,
			backgroundColor: { fill:'transparent' }
		  };
  
		  var chart = new google.visualization.PieChart(document.getElementById('dashboard-browser-chart'));
		  chart.draw(data, options);
			
		// Line Chart
		var data = google.visualization.arrayToDataTable([
          ['Date', 'Hits', 'Unique'],
          ['Jan',  1000,      400],
          ['Feb',  1170,      460],
          ['Mar',  660,       1120],
          ['Apr',  1030,      540],
		  ['May',  1330,      540]
        ]);

        var options = {
          title: 'Website Visits',
		  forceIFrame: false,
		  backgroundColor: { fill:'transparent' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('dashboard-visit-chart'));
        chart.draw(data, options);
	
		// Gauge Chart
		
		var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Registrations', 80],
          ['Comments', 55],
		  ['Reviews', 34]
        ]);
		
        var options = {
          width: Math.round(($('#dashboard-visit-chart').width())),
		  height: $('#dashboard-visit-chart').height()-30, 
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5,
		  forceIFrame: false,
		  backgroundColor: { fill:'transparent' }
        };

        var chart = new google.visualization.Gauge(document.getElementById('dashboard-new-registrations-gauge-chart'));
        chart.draw(data, options);
		
		$('#dashboard-new-registrations-gauge-chart').height($('#dashboard-visit-chart').height()-30);
		
		// Calendar
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			theme: false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay '
			},
			 
			aspectRatio: 3,
			editable: true,
			events: [
				{
					title: 'All Day Event',
					start: new Date(y, m, 1)
				},
				{
					title: 'Long Event',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2)
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
	}
	
});

