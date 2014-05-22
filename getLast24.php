<?php
// ini_set("memory_limit","2048M");
include("connect.php");
$link=Conection();

// SQL query for past 24 hours.
$query24 =  "SELECT * FROM dht WHERE time >= DATE_SUB(NOW(), INTERVAL 1 DAY)";

// SQL query for past week.

// SQL query for past month.

// Query and return select data
$result = mysql_query($query24,$link);

$table = array();
$table['cols'] = array(
    array('id' => "", 'label' => 'Time', 'pattern' => "", 'type' => 'string'),
    array('id' => "", 'label' => 'Temperature', 'pattern' => "", 'type' => 'number'),
    array('id' => "", 'label' => 'Humidity', 'pattern' => "", 'type' => 'number')
);
$rows = array();

while ($nt = mysql_fetch_assoc($result))
    {
    $temp = array();
    $temp[] = array('v' => $nt['time'], 'f' =>NULL);
    $temp[] = array('v' => $nt['tf'], 'f' =>NULL);
    $temp[] = array('v' => $nt['hum'], 'f' =>NULL);
    $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;
$jsonTable = json_encode($table, JSON_NUMERIC_CHECK);
//print_r($table);
echo $jsonTable;


?>