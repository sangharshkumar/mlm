<?php

$date = $_POST['value'];
$date = str_replace('-', '||', $date);
$date = str_replace('/', '-', $date);
$date = explode("||", $date);
$from_date = $date[0];
$from_date = strtotime($from_date);
$to_date = $date['1'];
$to_date = strtotime($to_date);

$output = income_graph($from_date, $to_date);
$pin_graph = $output['pin_graph'];
$payout_graph = $output['payout_graph'];
$profit_graph = $output['profit_graph'];
$wallet_graph = $output['wallet_graph'];
$time_range = $output['time_range'];
?>

 <div id="income_graph"></div>
  <?php include("chart/income-chart.php"); ?>