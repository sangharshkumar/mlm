<?php
include("../../db.php");
include("../assets/php/functions.php");

if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


$active_tab = 'dashboard';

$output = dashboard_graph($lastweek, $current_date);
$registration_count = $output['registration_count'];
$time_range = $output['time_range'];



$left_joining = left_count($admin_id);
$right_joining = right_count($admin_id);
$today_joining = today_count($admin_id);
$active_team_count = active_team_count();

//

$members_wallet = members_wallet('');
$members_wallet_full = members_wallet("full");
$total_income = show_total_income('');
$total_income_full= show_total_income('full');
$payout = payout('');
$payout_full = payout('full');
$pins_earning = pins_earning('');
$pins_earning_full = pins_earning('full');

//

$request_count = request_count();
$pending_amount = pending_amount('');
$pending_amount_full = pending_amount('full');
$admin_charge = total_charge('');
$admin_charge_full = total_charge('full');
$today_income = today_income('');
$today_income_full = today_income('full');
//
$total_tickets = total_tickets("all");
$pending_tickets = pending_tickets("all");
$open_tickets = open_tickets("all");
$closed_tickets = closed_tickets("all");
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
                        <h4 class="page-title">Dashboard</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                       <a href="<?php echo $base_url; ?>/admin/genealogy/total-team.php">
                        <div class="card border-bottom border-primary">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-primary display-5"><i class="icon-people"></i></span></div>
                                    <div><span>Left Joining</span>
                                        <h3 class="font-medium mb-0"><?php echo $left_joining; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </a>
                    </div>

                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                       <a href="<?php echo $base_url; ?>/admin/genealogy/total-team.php">
                        <div class="card border-bottom border-primary">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-primary display-5"><i class="icon-people"></i></span></div>
                                    <div><span>Right Joining</span>
                                        <h3 class="font-medium mb-0"><?php echo $right_joining; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                       <a href="<?php echo $base_url; ?>/admin/genealogy/total-team.php">
                        <div class="card border-bottom border-primary">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-primary display-5"><i class="icon-people"></i></span></div>
                                    <div><span>Active Members</span>
                                        <h3 class="font-medium mb-0"><?php echo $active_team_count; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                       <a href="<?php echo $base_url; ?>/admin/genealogy/total-team.php">
                        <div class="card border-bottom border-primary">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-primary display-5"><i class="icon-people"></i></span></div>
                                    <div><span>Today Joining</span>
                                        <h3 class="font-medium mb-0"><?php echo $today_joining; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </a>
                    </div>
                    <!-- col -->

                    <!-- col -->
                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $members_wallet_full; ?>" class="col-lg-3 col-md-6">
                      <a href="<?php echo $base_url; ?>/admin/report/income.php">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-success display-5"><i class="ti-wallet"></i></span></div>
                                    <div><span>Users Wallet</span>
                                        <h3 class="font-medium mb-0"><?php echo $members_wallet; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $total_income_full; ?>" data-toggle="tooltip">
                      <a href="<?php echo $base_url; ?>/admin/report/income.php">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-success display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                    <div><span>Total Earning</span>
                                        <h3 class="font-medium mb-0"><?php echo $total_income; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $payout_full; ?>" data-toggle="tooltip">
                      <a href="<?php echo $base_url; ?>/admin/report/income.php">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-success display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                    <div><span>Paid</span>
                                        <h3 class="font-medium mb-0"><?php echo $payout; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $pins_earning_full; ?>" data-toggle="tooltip">
                      <a href="<?php echo $base_url; ?>/admin/report/income.php">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-success display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                    <div><span>E-Pins Earning</span>
                                        <h3 class="font-medium mb-0"><?php echo $pins_earning; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                    <!-- col -->


                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <a href="<?php echo $base_url; ?>/admin/wallet/payout.php">
                            <div class="card border-bottom border-info">
                                <div class="card-body">
                                    <div class="text-dark d-flex align-items-center">
                                        <div class="mr-2"><span class="text-info display-5"><i class="icon-people"></i></span></div>
                                        <div><span>Payout Requests</span>
                                            <h3 class="font-medium mb-0"><?php echo $request_count; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $pending_amount_full; ?>" data-toggle="tooltip">
                     <a href="<?php echo $base_url; ?>/admin/wallet/payout.php">
                        <div class="card border-bottom border-info">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-info display-5"><i class="ti-timer"></i></span></div>
                                    <div><span>Pending</span>
                                        <h3 class="font-medium mb-0"><?php echo $pending_amount; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </a>
                    </div>
                    <!-- col -->

                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $admin_charge_full; ?>" data-toggle="tooltip">
                     <a href="<?php echo $base_url; ?>/admin/wallet/payout.php">
                        <div class="card border-bottom border-info">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-info display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                    <div><span>Admin Charge</span>
                                        <h3 class="font-medium mb-0"><?php echo $admin_charge; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6" data-placement="top" title="<?php echo $today_income_full; ?>" data-toggle="tooltip">
                     <a href="<?php echo $base_url; ?>/admin/wallet/payout.php">
                        <div class="card border-bottom border-info">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-info display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                    <div><span>Today Income</span>
                                        <h3 class="font-medium mb-0"><?php echo $today_income; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    </div>
                    <!-- col -->

                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                     <a href="<?php echo $base_url; ?>/admin/support/">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-warning display-5"><small><i class="icon-speech"></i></small></span></div>
                                    <div><span>Total Tickets</span>
                                        <h3 class="font-medium mb-0"><?php echo $total_tickets; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                     <a href="<?php echo $base_url; ?>/admin/support/">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-warning display-5"><small><i class="icon-speech"></i></small></span></div>
                                    <div><span>Pending Tickets</span>
                                        <h3 class="font-medium mb-0"><?php echo $pending_tickets; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                     <a href="<?php echo $base_url; ?>/admin/support/">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-warning display-5"><small><i class="icon-speech"></i></small></span></div>
                                    <div><span>Open Tickets</span>
                                        <h3 class="font-medium mb-0"><?php echo $open_tickets; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                     <a href="<?php echo $base_url; ?>/admin/support/">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="text-dark d-flex align-items-center">
                                    <div class="mr-2"><span class="text-warning display-5"><small><i class="icon-speech"></i></small></span></div>
                                    <div><span>Closed Tickets</span>
                                        <h3 class="font-medium mb-0"><?php echo $closed_tickets; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    </div>
                    <!-- col -->
                </div>

                <!--  GRAPH START -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h4 class="card-title">Registration Summary</h4>
                                <p id="cs_date" class="card-subtitle"><?php echo $moment_time; ?></p>
                            </div>
                            <div class="ml-auto pb-3 col-4 row align-items-center">
                                <input value="<?php echo $moment_time; ?>" class="col-8 form-control" type="text" id="dashboard-time-range">
                                <button class="col-4 btn btn-info" id="dashboard_search">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="dashboard_graph_container" class="col-lg-12">
                                <div id="dashboard_graph"></div>
                            </div>
                            <!-- column -->
                        </div>
                    </div>
                </div>
                <!--  GRAPH END -->

            </div>
        </div>
    </div>



    </div>
    <?php
    include("../../assets/nav/footer.php");
    ?>
    <script src="<?php echo $base_url; ?>/admin/assets/js/highcharts.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/moment.min.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/daterangepicker.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/dashboard.js"></script>
    <?php include("../chart/dashboard-graph.php"); ?>
</body>

</html>