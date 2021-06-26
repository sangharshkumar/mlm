<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'support';


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}

$total_tickets_all = total_tickets("all");
$pending_tickets_all = pending_tickets("all");
$open_tickets_all = open_tickets("all");
$closed_tickets_all = closed_tickets("all");

$total_tickets_today = total_tickets("today");
$pending_tickets_today = pending_tickets("today");
$open_tickets_today = open_tickets("today");
$closed_tickets_today = closed_tickets("today");

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
                        <h4 class="page-title">Support</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Support</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <div class="row m-0 pb-4">
                    <div class="ml-auto dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"></button>
                        <div id="ticket-dropdown" class="shadow dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><i class="cs-icon mdi mdi-file-tree"></i>Today</a>
                            <a class="dropdown-item" href="#"><i class="cs-icon mdi mdi-file-tree"></i>Life Time</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                        <div id="support_cards_container" class="row">
                            <div class="col-lg-3 col-md-6">
                                <div target="total_support_card" class="active-support-card card border-bottom border-info">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 style="display:none" class="ticket-all"><?php echo $total_tickets_all; ?></h2>
                                                <h2 class="ticket-today"><?php echo $total_tickets_today; ?></h2>
                                                <h6 style="display:none" class="ticket-all" class="text-info">Total</h6>
                                                <h6 class="ticket-today text-info">Total Pending</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-info display-6"><i class="icon-speech"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div target="pending_support_card" class="card border-bottom border-warning">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 style="display:none" class="ticket-all"><?php echo $pending_tickets_all; ?></h2>
                                                <h2 class="ticket-today"><?php echo $pending_tickets_today; ?></h2>
                                                <h6 class="text-warning">Pending</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-warning display-6"><i class="icon-speech"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div target="open_support_card" class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 style="display:none" class="ticket-all" ><?php echo $open_tickets_all; ?></h2>
                                                <h2 class="ticket-today" ><?php echo $open_tickets_today; ?></h2>
                                                <h6 class="text-success">Open</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="icon-speech"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div target="closed_support_card" class="card border-bottom border-danger">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 style="display:none" class="ticket-all" ><?php echo $closed_tickets_all; ?></h2>
                                                <h2 class="ticket-today" ><?php echo $closed_tickets_today; ?></h2>
                                                <h6 class="text-danger">Closed</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-danger display-6"><i class="icon-speech"></i></span>
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
                                                        <th>Subject</th>
                                                        <th>User Name</th>
                                                        <th>User Id</th>
                                                        <th>Activation Date </th>
                                                        <th>Last Reply Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="support_tbl_body" id="total_support_card">
                                                    <?php echo supports_list("total"); ?>
                                                </tbody>
                                                <tbody style="display: none;" class="support_tbl_body" id="pending_support_card">
                                                    <?php echo supports_list("pending"); ?>
                                                </tbody>
                                                <tbody style="display: none;" class="support_tbl_body" id="open_support_card">
                                                    <?php echo supports_list("open"); ?>
                                                </tbody>
                                                <tbody style="display: none;" class="support_tbl_body" id="closed_support_card">
                                                    <?php echo supports_list("closed"); ?>
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
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
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