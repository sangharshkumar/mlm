<?php
include("../../db.php");
$active_tab = 'transfered-fund';
$page_tab = 'wallet';
include("../assets/php/functions.php");


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}
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
                        <h4 class="page-title">Transfered Fund</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Transfered Fund</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
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
                                                <th>Request Date</th>
                                                <th>Payment Date</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php echo transfered_fund_tbl(); ?>
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