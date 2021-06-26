<?php
$date = $_POST['value'];
$date = str_replace('-', '||', $date);
$date = str_replace('/', '-', $date);
$date = explode("||", $date);
$from_date = $date[0];
$from_date = strtotime($from_date);
$to_date = $date[1];
$to_date = strtotime($to_date);

$total_pins = custom_total_pins($from_date, $to_date);
$active_pins = custom_active_pins($from_date, $to_date);
$inactive_pins = custom_inactive_pins($from_date, $to_date);

?>
<div class="row">

    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-info">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2><?php echo $total_pins; ?></h2>
                        <h6 class="text-info">Total Pins</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-info display-6"><i class="ti-key"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-info">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2><?php echo $inactive_pins; ?></h2>
                        <h6 class="text-info">Inactive Pins</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-info display-6"><i class="ti-key"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2><?php echo $active_pins; ?></h2>
                        <h6 class="text-success">Active Pins</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-success display-6"><i class="ti-key"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>