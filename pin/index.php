<?php
include("../db.php");
$active_tab = 'pin';
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$user_id = $loggedin_user_id;
$wallet = wallet($user_id);
$total_pins = total_pins($user_id);
$active_pins = active_pins($user_id);
$inactive_pins = inactive_pins($user_id);
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
                        <h4 class="page-title">Generate Pin</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Generate Pin</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-5">
                        <div class="py-2 card">
                            <div class="card-body">
                                <h4 class="card-title">Generate Pin</h4>
                                <form id="pin_generate_form" class="resetonload">
                                    <div class="form-row">
                                        <div class="col-12 mb-3">
                                            <label>Pin Count</label>
                                            <input id="pin_count" name="pin_count" type="text" class="numbers-only form-control" placeholder="Pin Count" required="">
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Price</label>
                                            <input id="pin_price" readonly type="text" class="disabled form-control" placeholder="Price" required="">
                                        </div>

                                    </div>
                                    <div class="text-right float-right p-0 m-0 row">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div style="height:max-content;" class="row">
                            <div class="col-sm-6">
                                <div class="card bg-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 class="text-white"><?php echo $c_symbol; ?><?php echo $wallet; ?></h2>
                                                <h6 class="text-white">Wallet</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-white display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 class="text-white"><?php echo $total_pins; ?></h2>
                                                <h6 class="text-white">Total Pins</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-white display-6"><i class="ti-key"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card bg-secondary">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 class="text-white"><?php echo $active_pins; ?></h2>
                                                <h6 class="text-white">Active Pins</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-white display-6"><i class="ti-key"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card bg-danger">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2 class="text-white"><?php echo $inactive_pins ?></h2>
                                                <h6 class="text-white">Inactive Pins</h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-white display-6"><i class="ti-key"></i></span>
                                            </div>
                                        </div>
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
                                    <table class="table product-overview" id="pin_table">
                                        <thead>
                                            <tr>
                                                <th>Serial No.</th>
                                                <th>Pin</th>
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th>Activation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo pin_tbl_data($user_id); ?>
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
        <?php
        include("../assets/nav/footer.php");
        ?>

        <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
        <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#pin_table').DataTable();
            });
        </script>
</body>

</html>