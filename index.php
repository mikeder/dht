<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 
Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>Data of Sensor</title>
<!-- <link rel="stylesheet" href="main.css"> No style for now, gauges dont center properly.  -->
<!-- BEGIN GAUGE -->
<!-- Invisible PHP stuff going on here to assign temp and humidity variables
    $result=mysql_query("select * from dht order by id desc limit 1",$link);
    $row = mysql_fetch_array($result);
    $temp = $row["tf"];
    $hum = $row["hum"];
-->
    
<!-- Connect to DB and select most recent values -->
<?php
    include("connect.php");
    $link=Conection();
    $result=mysql_query("select * from dht order by id desc limit 1",$link);
    $row = mysql_fetch_array($result);
    $temp = $row["tf"];
    $hum = $row["hum"];
?>
    <meta http-equiv="refresh" content="60">
    <!--Load the AJAX API-->
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type='text/javascript'>
        
    google.load('visualization', '1', {packages:['gauge']});
    google.setOnLoadCallback(drawGauge);
    function drawGauge() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          // Insert PHP Variables here
          ['Temp', <?PHP echo $temp; ?>],
          ['Humidity', <?PHP echo $hum; ?>],
         
        ]);

        var options = {
          width: 600, height: 200,
          redFrom: 90, redTo: 100,
          yellowFrom:80, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('gauge'));
        chart.draw(data, options);
      }
    </script>
<!-- END GAUGE -->
<!-- BEGIN CHART -->
    <script type="text/javascript">
    
    // Load the Visualization API and the chart package.
    google.load('visualization', '1', {'packages':['corechart', ]});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
    
    // Function to grab JSON formatted values from getLast24.php
    function drawChart() {
      var jsonData = $.ajax({
          url: "getLast24.php",
          dataType:"json",
          async: false
          }).responseText;
          
      // Create data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      // Set chart options
      var options = {
          // displayAnnotations: true,
        title: 'Past 24 Hours',
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
<!--END CHART -->
</head>
<body>
<!-- Draw Gauges -->
<div><h1>Current Readings:</h1></div>
<div id='gauge'></div>
<!-- Draw Line Chart -->
<div id="chart" align="left" style="width: 1000px; height: 500px;"></div>
<!-- Draw table of 25 most recent DB entries. -->
<h3>Last 25 database entries from DHT22 Sensor</h3>
<hr>
<?php
   // include("connect.php"); --Already included above.
   $link=Conection();
   $result2=mysql_query("select * from dht order by id desc limit 25",$link);
?>
<table border="1" cellspacing="1" cellpadding="1">
      <tr>
         <td>&nbsp;Time&nbsp;</td>
         <td>&nbsp;Temp (F)&nbsp;</td>
         <td>&nbsp;Humidity (%)&nbsp;</td>
       </tr>
<?php     
   while($row = mysql_fetch_array($result2)) {
       printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s </td><td> &nbsp;%s&nbsp;</td></tr>\n", $row["time"], $row["tf"], $row["hum"]);
   }
   mysql_free_result($result);
?>
    
</table>
</body>
</html>
