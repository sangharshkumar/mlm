<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$active_tab = 'wallet';
$page_tab = 'balance';

$user_id = $loggedin_user_id;
$wallet = wallet($user_id);
$income = income($user_id);
$total_income = total_income($user_id);
$total_withdrawl = total_withdrawl($user_id);
$expenditure = expenditure($user_id);
$pending = pending($user_id);
$last_added_money = last_added_money($user_id);
$last_withdrawl_money = last_withdrawl_money($user_id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
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
                        <h4 class="page-title">Wallet</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active"><a href="#">Balance</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Wallet</li>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $wallet; ?></h2>
                                        <h6 class="text-success">Wallet</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="ti-wallet"></i></span>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $income; ?></h2>
                                        <h6 class="text-success">Income</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-cyan">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $total_income; ?></h2>
                                        <h6 class="text-cyan">Total Income</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-cyan">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $total_withdrawl; ?></h2>
                                        <h6 class="text-cyan">Total Withdrawl</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-orange">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $expenditure; ?></h2>
                                        <h6 class="text-orange">Expenditure</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-orange display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-orange">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $pending; ?></h2>
                                        <h6 class="text-orange">Pending</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-orange display-6"><i class="ti-timer"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="add_amount" class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $last_added_money; ?></h2>
                                        <h6 class="text-success">Last Added Money</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="withdraw_amount" class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $last_withdrawl_money; ?></h2>
                                        <h6 class="text-success">Last Withdrawl Money</h6>
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
                                    <table data-sorter="datesSorter" class="table product-overview" id="data_table">
                                        <thead>
                                            <tr>
                                                <th>Serial No.</th>
                                                <th>Amount</th>
                                                <th>Txn Charge</th>
                                                <th>Net Amount</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo show_transaction_history($user_id); ?>
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
    include("../assets/nav/footer.php");
    ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable({
                 "order": [[ 4, "desc" ]]
            });
        });
    </script>
</body>

</html>