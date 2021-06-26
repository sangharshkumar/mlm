<?php
$date = $_POST['value'];
$date = str_replace('-', '||', $date);
$date = str_replace('/', '-', $date);
$date = explode("||", $date);
$from_date = $date[0];
$from_date = strtotime($from_date);
$to_date = $date['1'];
$to_date = strtotime($to_date);

$output = dashboard_graph($from_date, $to_date);
$registration_count = $output['registration_count'];
$time_range = $output['time_range'];
?>

 <div id="dashboard_graph"></div>
 <?php include("chart/dashboard-graph.php");
