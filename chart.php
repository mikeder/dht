<html>
  <head>
    <title>T/H Past 24hrs</title>
    <meta http-equiv="refresh" content="120">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart', ]});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "getLast24.php",
          dataType:"json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      // Set chart options
      var options = {
          // displayAnnotations: true,
        title: 'Temperature and Humidity Readings (Upper Shop - Past 24 Hours)',
        curveType: 'function',
        legend: { position: 'bottom' },
        focusTarget: 'category',
        hAxis: {color: '#000000', title: 'Date/Time', ticks: ['24hrs ago', 'Now']},
        vAxis: {gridlines: {count: 15}, format: '##', ticks: [10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95]}
        };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('chart'));
      chart.draw(data, options);
    }

    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart" style="width: 1200px; height: 500px;"></div>
  </body>
</html>