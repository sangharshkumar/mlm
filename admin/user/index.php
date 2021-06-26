<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'total-team';
$page_tab = 'genealogy';

if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


if (!isset($_GET['user_id'])) {
    header("location:$error_page");
    exit();
}

$id = $_GET['user_id'];
if (!is_user_id($id)) {
    header("location:$error_page");
    exit();
}
if (!isset($_GET['action'])) {
    header("location:$error_page");
    exit();
}

$user_id = $id;
$action = $_GET['action'];

if ($action == "level-income") {
    include("level-income.php");
    exit();
} else 
if ($action == "transactions") {
    include("transactions.php");
    exit();
} else 
   if ($action == "withdraws") {
    include("withdraws.php");
    exit();
} else 
   if ($action == "deposits") {
    include("deposits.php");
    exit();
} else 
   if ($action == "direct-referral") {
    include("direct-referral.php");
    exit();
} else 
   if ($action == "referral-income") {
    include("referral-income.php");
    exit();
} else 
   if ($action == "pin_count") {
    include("pin_count.php");
    exit();
} else 
   if ($action == "pin-expenditure") {
    include("pin-expenditure.php");
    exit();
} else 
   if ($action == "profile") {
} else {
    header("location:$error_page");
    exit();
}


$user_name = user_name($user_id);
$wallet = $c_symbol . wallet($user_id);
$last_withdraw = $c_symbol . last_withdrawl_money($user_id);
$last_deposit = $c_symbol . last_added_money($user_id);
$placement_id = placement_id($user_id);
$referred_by = referred_by($user_id);
$referred_by = ($referred_by == "root") ? $referred_by : user_name($referred_by);
$user_registration_date = user_registration_date($user_id);
$user_status = user_status($user_id);
$status_label = ($user_status == "active") ? "success" : "danger";
$referred_by_id = referred_by($user_id);
$referred_by_id = ($referred_by_id == "root") ? "$admin_id" : $referred_by_id;
// ########
$first_name = user_first_name($user_id);
$last_name = user_last_name($user_id);
$email = user_email($user_id);
$phone = user_phone($user_id);
$address = user_address($user_id);
$pincode = user_pincode($user_id);
$account_number = user_account_number($user_id);
$user_upi = user_upi($user_id);
// ########



// #####################

$total_transactions = total_transactions($user_id);
$total_withdraws = $c_symbol . total_withdrawl($user_id);
$total_deposit = $c_symbol . total_deposit($user_id);
$level_income = $c_symbol . level_income($user_id);
$direct_referral = direct_referral_count($user_id);
$referral_income = $c_symbol . referral_income($user_id);
$pair_count = pair_count($user_id);
$pin_count = total_pins($user_id);
$pin_expenditure = $c_symbol . expenditure($user_id);
// #####################

$user_account_img = user_account_image($user_id);
$user_level = level($user_id);
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
                        <h4 class="page-title">User Profile</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
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
                        <div class=" card">
                            <div class="card-body">
                                <h4 class="card-title">Profile</h4>
                                <div class="profile_img_container">
                                    <div class="img_center">
                                        <img style="width:100%" id="avatarimage" src="<?php echo user_image($user_id); ?>" alt="">
                                    </div>
                                </div>
                                <div class="user-information">
                                    <label>Profile Details</label>
                                    <div class="py-1 information-data-row">
                                        <div>
                                            <span>User Id</span>
                                            <span><?php echo $user_id; ?></span>
                                        </div>
                                        <div>
                                            <span>User Name</span>
                                            <span><?php echo $user_name; ?></span>
                                        </div>
                                        <div>
                                            <span>Wallet</span>
                                            <span><?php echo $wallet; ?></span>
                                        </div>
                                        <div>
                                            <span>Last Withdraw</span>
                                            <span><?php echo $last_withdraw; ?></span>
                                        </div>
                                        <div>
                                            <span>Last Deposit</span>
                                            <span><?php echo $last_deposit; ?></span>
                                        </div>
                                        <div>
                                            <span>Level</span>
                                            <span><?php echo $user_level; ?></span>
                                        </div>
                                        <div>
                                            <span>Placement Id</span>
                                            <span><?php echo $placement_id; ?></span>
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
                                            <span class="label label-<?php echo $status_label; ?>"><?php echo $user_status; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <div class=" col-lg-8 col-md-12">
                        <div class="row">
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class=" card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $level_income; ?></h2>
                                                <h6 class="text-success"> Level Income </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/level-income' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $total_deposit; ?></h2>
                                                <h6 class="text-success"> Total Deposit </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/deposits' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $total_transactions; ?></h2>
                                                <h6 class="text-success"> Total Transactions </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class=" ti-exchange-vertical "></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/transactions' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class=" card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $total_withdraws; ?></h2>
                                                <h6 class="text-success"> Total Withdrawals </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/withdraws' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $direct_referral; ?></h2>
                                                <h6 class="text-success"> Direct Referral </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class=" icon-people "></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/direct-referral' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $referral_income; ?></h2>
                                                <h6 class="text-success"> Referral Income </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/referral-income' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                           
                          
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $pin_count; ?></h2>
                                                <h6 class="text-success"> Pin Count </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-key"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/pin-expenditure' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                            <!-- Card -->
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-bottom border-success">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h2><?php echo $pin_expenditure; ?></h2>
                                                <h6 class="text-success"> Pin Expenditure </h6>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="text-success display-6"><i class="ti-wallet"></i></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo $base_url . '/admin/user/' . $user_id . '/pin-expenditure' ?>" class="mt-1 btn btn-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card -->
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-row">
                                            <h4 class="card-title">Profile Detail</h4>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>User Id</label>
                                                <input value="<?php echo $user_id; ?>" readonly type="text" class="form-control" placeholder="User Id" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>User Name</label>
                                                <input value="<?php echo $user_name; ?>" readonly type="text" class="form-control" placeholder="User Name" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Referral Id</label>
                                                <input value="<?php echo $referred_by; ?>" readonly type="text" class="form-control" placeholder="Referral Id" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Placement Id</label>
                                                <input value="<?php echo $placement_id; ?>" readonly type="text" class="form-control" placeholder="Placement Id" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>First Name</label>
                                                <input value="<?php echo $first_name; ?>" readonly type="text" class="form-control" placeholder="First Name" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Last Name</label>
                                                <input value="<?php echo $last_name; ?>" readonly type="text" class="form-control" placeholder="Last Name" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Email</label>
                                                <input value="<?php echo $email; ?>" readonly type="text" class="form-control" placeholder="Email" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Phone</label>
                                                <input value="<?php echo $phone; ?>" readonly type="text" class="form-control" placeholder="Phone" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Address</label>
                                                <input value="<?php echo $address; ?>" readonly type="text" class="form-control" placeholder="Address" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Pincode</label>
                                                <input value="<?php echo $pincode; ?>" readonly type="text" class="form-control" placeholder="Pincode" required="">
                                            </div>
                                            <div class="col-md-12 col-lg-12 mb-3">
                                                <label>Registration Date</label>
                                                <input value="<?php echo $user_registration_date; ?>" readonly type="text" class="form-control" placeholder="Registration Date" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-row">
                                            <h4 class="card-title">Payment Details</h4>
                                            <div class="col-12 mb-3">
                                                <label class="">QR Code</label>
                                                <div class="payment-img-container">
                                                    <div style="<?php if ($user_account_img !== $base_url . '/assets/images/users/') {
                                                                    echo "display:none";
                                                                }
                                                                ?>" id="pay_upload">
                                                        <i class="icon-cloud-upload"></i>
                                                        <h4 class="text-center">QR CODE</h4>
                                                    </div>
                                                    <img id="payimage" class="img-fluid" src="<?php echo $user_account_img; ?>" alt="">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Phone Pay/ Paytm Id/ Google Pay</label>
                                                <input readonly value="<?php echo $account_number; ?>" type="text" class="form-control" placeholder="Number">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Upi Id</label>
                                                <input readonly value="<?php echo $user_upi; ?>" type="text" class="form-control" placeholder="Upi@ybl">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("../../assets/nav/footer.php");
    ?>
    <script src="<?php echo $base_url; ?>/admin/assets/js/dashboard.js"></script>
</body>

</html>