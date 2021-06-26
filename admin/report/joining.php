<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'joining';
$page_tab = 'report';


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


$output = joining_graph($lastweek, $current_date);
$left_count_graph = $output['left_count_graph'];
$right_count_graph = $output['right_count_graph'];
$time_range = $output['time_range'];

$left_count = left_count($admin_id);
$right_count = right_count($admin_id);
$total_count = total_count($admin_id);
$today_count = today_count($admin_id);
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
        include("../assets/nav/navbar.php");
        ?>


        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title">Joining</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Joining</li>
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
                                        <h4 class="card-title">Members Joining</h4>
                                        <p id="cs_date" class="card-subtitle"><?php echo $moment_time; ?></p>
                                    </div>
                                    <div class="ml-auto pb-3 col-4 row align-items-center">
                                        <input value="<?php echo $moment_time; ?>" class="col-8 form-control" type="text" id="joining-time-range">
                                        <button class="col-4 btn btn-info" id="joining_search">Search</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="joining_graph_container" class="col-lg-12">
                                        <div id="joining_graph"></div>
                                    </div>
                                    <!-- column -->
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <div class="row mb-0">
                                    <!-- col -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#50B432" class="display-5"><i class=" icon-people "></i></span></div>
                                            <div><span>Left Joining</span>
                                                <h3 class="font-medium mb-0"><?php echo $left_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#2962E1" class="display-5"><i class=" icon-people "></i></span></div>
                                            <div><span>Right Joining</span>
                                                <h3 class="font-medium mb-0"><?php echo $right_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#ED561B" class="display-5"><i class=" icon-people "></i></span></div>
                                            <div><span>Total Joining</span>
                                                <h3 class="font-medium mb-0"><?php echo $total_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span class="text-primary display-5"><i class=" icon-people "></i></span></div>
                                            <div><span>Today Joining</span>
                                                <h3 class="font-medium mb-0"><?php echo $today_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4 class="card-title">Joining Summary</h4>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table product-overview" id="data_table">
                                        <thead>
                                            <tr>
                                                <th>Serial No.</th>
                                                <th>User Name</th>
                                                <th>User Id</th>
                                                <th>Referral Id</th>
                                                <th>Placement Type</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo joining_user_tbl(); ?>
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
    include("../../assets/nav/footer.php");
    ?>
    <script src="<?php echo $base_url; ?>/admin/assets/js/dashboard.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/highcharts.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/moment.min.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/daterangepicker.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
    </script>
    <?php include("../chart/joining-graph.php"); ?>
</body>

</html>