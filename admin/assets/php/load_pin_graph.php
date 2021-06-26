 <?php
    $date = $_POST['value'];
    $date = str_replace('-', '||', $date);
    $date = str_replace('/', '-', $date);
    $date = explode("||", $date);
    $from_date = $date[0];
    $from_date = strtotime($from_date);
    $to_date = $date['1'];
    $to_date =  strtotime($to_date);

    $output = pin_graph($from_date, $to_date);
    $active_pins_count = $output['active_pins_count'];
    $sold_pins_count = $output['sold_pins_count'];
    $time_range = $output['time_range'];
?>
 <div id="pin_graph"></div>
 <?php include("chart/pin_graph.php"); ?>