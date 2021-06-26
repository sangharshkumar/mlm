<?php
include "../../db.php";
include "../assets/php/functions.php";
$active_tab = 'e-pin';
$page_tab = 'report';

if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


$total_pins = custom_total_pins($lastweek,$current_date);
$active_pins = custom_active_pins($lastweek,$current_date);
$inactive_pins = custom_inactive_pins($lastweek,$current_date);

$output = pin_graph($lastweek, $current_date);
$active_pins_count = $output['active_pins_count'];
$sold_pins_count = $output['sold_pins_count'];
$time_range = $output['time_range'];

$moment_time = date("d F, Y", $lastweek) .' - '. date("d F, Y", $current_date);
?>



<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url; ?>/admin/assets/css/daterangepicker.css" />
</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <?php
        include "../assets/nav/navbar.php";
        ?>


        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title">E-Pin</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">E-Pin</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4 class="card-title">E-PIN Summary</h4>
                                        <p id="cs_date" class="card-subtitle"><?php echo $moment_time; ?></p>
                                    </div>
                                    <div class="ml-auto pb-3 col-4 row align-items-center">
                                        <input value="<?php echo $moment_time; ?>" class="col-8 form-control" type="text" id="pin-time-range">
                                        <button class="col-4 btn btn-info" id="pin_search">Search</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="pin_graph_container" class="col-lg-12">
                                        <div id="pin_graph"></div>
                                    </div>
                                    <!-- column -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="e_pin_update">
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
 </section>
                    <div class="row">
                        <!-- Column -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h4 class="card-title">E-Pin Summary</h4>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table product-overview" id="pin_table">
                                            <thead>
                                                <tr>
                                                    <th>Serial No.</th>
                                                    <th>User Id</th>
                                                    <th>User Name</th>
                                                    <th>Pin</th>
                                                    <th>Created Date</th>
                                                    <th>Activation Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo pin_table($lastweek,$current_date); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
            </div>
        </div>



    </div>
    <?php
    include "../../assets/nav/footer.php";
    ?>
    <script src="<?php echo $base_url; ?>/admin/assets/js/dashboard.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/highcharts.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/moment.min.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/daterangepicker.js"></script>

    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pin_table').DataTable();
        });
    </script>
    <?php include("../chart/pin_graph.php"); ?>
</body>

</html>