<?php
include("../../db.php");
include("../assets/php/functions.php");
$page_tab = 'wallet';


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}

if (!isset($_GET['withdraw_id'])) {
    header("location:$error_page");
    exit();
}

$id = $_GET['withdraw_id'];
$query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$id' ");
if (!mysqli_num_rows($query)) {
    header("location:$error_page");
    exit();
}

$withdraw_id = $id;
$data = mysqli_fetch_array($query);
$user_id = $data['user_id'];
//######## User Details ########
$user_email = user_email($user_id);
$user_name = user_name($user_id);
$user_registration_date = user_registration_date($user_id);
$wallet = $c_symbol . wallet($user_id);
$referred_by = referred_by($user_id);
$referred_by_id = referred_by($user_id);
$referred_by_id = ($referred_by_id == "root") ? "$admin_id" : $referred_by_id;
$referred_by = ($referred_by == "root") ? $referred_by : user_name($referred_by);
$user_status = user_status($user_id);
$user_status_label = ($user_status == "active") ? "success" : "danger";

$payment_img = payment_img($withdraw_id,$user_id);
$account_number = user_account_number($user_id);
$user_upi = user_upi($user_id);
//######## User Details ########



//######## Withdraw Details ########
$amount_requested = $data['amount'];
$admin_charge = $data['charge'];
$other_charge = $data['other_charge'];
$payable = $data['payable'];
$date = $data['requested_date'];
//######## Withdraw Details ########

$status = get_withdraw_status($withdraw_id);
$active_tab = ($status == "pending") ? "payout" : "transfered-fund";

$payment_date = $data['payment_date'];
$now = ($status == "success") ? $payment_date : time();
$datediff = $now - $date;
$withdraw_delay =  round($datediff / (60 * 60 * 24)) . " Days";

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/cropper.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <h4 class="page-title">Profile</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->
                    <div class="myprofile-card col-md-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Profile</h4>
                                <div class="profile_img_container">
                                    <div class="img_center">
                                        <img style="width:100%" id="avatarimage" src="<?php echo user_image($user_id); ?>" alt="">
                                    </div>
                                </div>
                                <div class="user-information">
                                    <label>Profile Details</label>
                                    <div class="information-data-row">
                                        <div>
                                            <span>User Id</span>
                                            <a href="<?php echo $base_url; ?>/admin/user/<?php echo $user_id; ?>/profile"><span><?php echo $user_id; ?></span></a>
                                        </div>
                                        <div>
                                            <span>User Name</span>
                                            <a href="<?php echo $base_url; ?>/admin/user/<?php echo $user_id; ?>/profile"><span><?php echo $user_name; ?></span></a>
                                        </div>
                                        <div>
                                            <span>Wallet</span>
                                            <span><?php echo $wallet; ?></span>
                                        </div>
                                        <div>
                                            <span>Referred By</span>
                                            <a href="<?php echo $base_url; ?>/admin/user/<?php echo $referred_by_id; ?>/profile"><span><?php echo $referred_by; ?></span></a>
                                        </div>
                                        <div>
                                            <span>Registration Date</span>
                                            <span class="re-date"><?php echo $user_registration_date; ?></span>
                                        </div>
                                        <div>
                                            <span>Status </span>
                                            <span class="label label-<?php echo $user_status_label; ?>"><?php echo $user_status; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Withdraw Detail</h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Currency</label>
                                                <input value="<?php echo $c_symbol; ?>" readonly type="text" class="form-control" placeholder="Currency" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Delay</label>
                                                <input value="<?php echo $withdraw_delay; ?>" readonly type="text" class="form-control" placeholder="Delay" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Payment Requested</label>
                                                <input value="<?php echo $amount_requested; ?>" readonly type="text" class="form-control" placeholder="Payment Requested" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Admin Charge (5%) </label>
                                                <input value="<?php echo $admin_charge; ?>" readonly type="text" class="form-control" placeholder="Charge" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Extra Charge</label>
                                                <input value="<?php echo $other_charge; ?>" readonly type="text" class="form-control" placeholder="Extra Charge" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Payable Amount</label>
                                                <input value="<?php echo $payable; ?>" readonly type="text" class="form-control" placeholder="Payable Amount" required="">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="col-12 mb-3">
                                                <label class="">QR Code</label>
                                                <div class="payment-img-container">
                                                    <div style="<?php if ($payment_img !== $base_url . '/assets/images/users/') {
                                                                    echo "display:none";
                                                                }
                                                                ?>" id="pay_upload">
                                                        <i class="icon-cloud-upload"></i>
                                                        <h4 class="text-center">QR CODE</h4>
                                                    </div>
                                                    <img id="payimage" class="img-fluid" src="<?php echo $payment_img; ?>" alt="">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Phone Pay/ Paytm Id/ Google Pay</label>
                                                <input readonly value="<?php echo $account_number; ?>" type="text" class="form-control" placeholder="number">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Upi Id</label>
                                                <input readonly value="<?php echo $user_upi; ?>" type="text" class="form-control" placeholder="upi@ybl">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-check">
                                                    <input <?php is_payment_method("qr", $withdraw_id); ?> value="qr" class="form-check-input" type="radio" name="payment_method" id="radio1">
                                                    <label class="form-check-label" for="radio1">
                                                        QR Code
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input <?php is_payment_method("paytm", $withdraw_id); ?> value="paytm" class="form-check-input" type="radio" name="payment_method" id="radio2">
                                                    <label class="form-check-label" for="radio2">
                                                        Phone Pay/ Paytm Id/ Google Pay
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input <?php is_payment_method("upi", $withdraw_id); ?> value="upi" class="form-check-input" type="radio" name="payment_method" id="radio3">
                                                    <label class="form-check-label" for="radio3">
                                                        Upi Id
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($status == "pending") {
                                ?>
                                    <div class="text-right float-right p-0 m-0 row">
                                        <a class="text-white mr-3 btn btn-secondary">Cancel</a>
                                        <button disabled id="approve_withdraw" class="btn btn-primary" type="submit">Approve</button>
                                    </div>
                                <?php
                                }
                                ?>
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
                                        <h4 class="card-title">Withdraw Summary</h4>
                                    </div>
                                </div>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo user_withdraw_summary($user_id) ?>
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script>
        var withdraw_id = '<?php echo $withdraw_id ?>';
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
    </script>
    <script src="<?php echo $base_url; ?>/admin/assets/js/dashboard.js"></script>
</body>

</html>