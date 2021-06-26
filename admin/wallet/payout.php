<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'payout';
$page_tab = 'wallet';


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}

$request_count = request_count();
$pending_amount = pending_amount('');
$pending_amount_full = pending_amount('full');
$paid_amount = paid_amount('');
$paid_amount_full = paid_amount('full');
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
                        <h4 class="page-title">Payout</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Payout</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

            <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $request_count; ?></h2>
                                        <h6 class="text-success">Request</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="icon-people"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $pending_amount_full; ?>" class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $pending_amount; ?></h2>
                                        <h6 class="text-success">Pending</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $paid_amount_full; ?>" class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $paid_amount; ?></h2>
                                        <h6 class="text-success">Paid</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-toggle="tooltip" data-placement="top" title="<?php echo $total_charge_full; ?>" class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $total_charge; ?></h2>
                                        <h6 class="text-success">Admin Charge</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
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
                                <div class="table-responsive">
                                    <table class="table product-overview" id="data_table">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>User Name</th>
                                                <th>User Id</th>
                                                <th>Amount</th>
                                                <th>Charge</th>
                                                <th>Payable Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php echo payout_tbl(); ?>
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
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
    </script>
</body>

</html>