<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'income';
$page_tab = 'report';

if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


$output = income_graph($lastweek, $current_date);
$pin_graph = $output['pin_graph'];
$payout_graph = $output['payout_graph'];
$profit_graph = $output['profit_graph'];
$wallet_graph = $output['wallet_graph'];
$time_range = $output['time_range'];


$total_income = show_total_income('');
$total_income_full = show_total_income('full');
$pins_earning = pins_earning('');
$pins_earning_full = pins_earning('full');
$payout = payout('');
$payout_full = payout('full');
$today_income = today_income('');
$today_income_full = today_income('full');
$members_wallet = members_wallet('');
$members_wallet_full = members_wallet('full');
$total_added_money = total_added_money('');
$total_added_money_full = total_added_money('full');
$total_charge = total_charge('');
$total_charge_full = total_charge('full');
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
                        <h4 class="page-title">Income</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Income</li>
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
                                        <h4 class="card-title">Income Summary</h4>
                                        <p id="cs_date" class="card-subtitle"><?php echo $moment_time; ?></p>
                                    </div>
                                    <div class="ml-auto pb-3 col-4 row align-items-center">
                                        <input value="<?php echo $moment_time; ?>" class="col-8 form-control" type="text" id="income-time-range">
                                        <button class="col-4 btn btn-info" id="income_search">Search</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="income_graph_container" class="col-lg-12">
                                        <div id="income_graph"></div>
                                    </div>
                                    <!-- column -->
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <div class="row mb-0">
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $total_income_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#50B432" class="display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Total Income</span>
                                                <h3 class="font-medium mb-0"><?php echo $total_income; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $pins_earning_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#2962E1" class="display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Pins Earning</span>
                                                <h3 class="font-medium mb-0"><?php echo $pins_earning; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $members_wallet_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color: #DDDF00;" class="display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Members Wallet</span>
                                                <h3 class="font-medium mb-0"><?php echo $members_wallet; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $today_income_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span class="text-primary display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Today Income</span>
                                                <h3 class="font-medium mb-0"><?php echo $today_income; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->

                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $total_added_money_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span class="text-cyan display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Total Added Money</span>
                                                <h3 class="font-medium mb-0"><?php echo $total_added_money; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $payout_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#ED561B" class="display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Total Paid</span>
                                                <h3 class="font-medium mb-0"><?php echo $payout; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $total_charge_full; ?>" class="col-lg-3 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2"><span style="color:#ED561B" class="display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Admin Charge</span>
                                                <h3 class="font-medium mb-0"><?php echo $total_charge; ?></h3>
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
                                        <h4 class="card-title">Income Summary</h4>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table product-overview" id="income_table">
                                        <thead>
                                            <tr>
                                                <th>Serial No.</th>
                                                <th>Added Money</th>
                                                <th>Paid</th>
                                                <th>Income</th>
                                                <th>Pins Earning</th>
                                                <th>Admin Charge </th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo income_graph_tbl(); ?>
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/highcharts.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/moment.min.js"></script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/daterangepicker.js"></script>
    <?php
    include("../chart/income-chart.php");
    ?>
</body>

</html>