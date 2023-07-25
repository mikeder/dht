<html>
  <head>
      
<?php
    include("connect.php");
    $link=Conection();
    $result=mysql_query("select * from dht order by id desc limit 1",$link);
    $row = mysql_fetch_array($result);
    $temp = $row["tf"];
    $hum = $row["hum"];
?>
    <meta http-equiv="refresh" content="60">
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawGauge);
      function drawGauge() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temp', <?PHP echo $temp; ?>],
          ['Humidity', <?PHP echo $hum; ?>],
         
        ]);

        var options = {
          width: 600, height: 200,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('gauge'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id='gauge'></div>
  </body>
</html>