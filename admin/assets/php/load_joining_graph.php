<?php
$date = $_POST['value'];
$date = str_replace('-', '||', $date);
$date = str_replace('/', '-', $date);
$date = explode("||", $date);
$from_date = $date[0];
$from_date = strtotime($from_date);
$to_date = $date['1'];
$to_date = strtotime($to_date);

$output = joining_graph($from_date, $to_date);
$left_count_graph = $output['left_count_graph'];
$right_count_graph = $output['right_count_graph'];
$time_range = $output['time_range'];

?>

 <div id="joining_graph"></div>
 <?php include("chart/joining-graph.php");
