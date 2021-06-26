<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$active_tab = 'dashboard';


$user_id = $loggedin_user_id;
$wallet = wallet($user_id);
$income = income($user_id);
$total_income = total_income($user_id);
$total_withdrawl = total_withdrawl($user_id);
$last_added_money = last_added_money($user_id);
$last_withdrawl_money = last_withdrawl_money($user_id);
$expenditure = expenditure($user_id);
$pending = pending($user_id);
//
$active_pins = active_pins($user_id);
$inactive_pins = inactive_pins($user_id);
$total_pins = total_pins($user_id);
//
$left_count = left_count($user_id);
$right_count = right_count($user_id);
$a = direct_all_referral_id($user_id);
$direct_left_count = $a['direct_left_count'];
$direct_right_count =  $a['direct_right_count'];
$direct_referral_count = direct_referral_count($user_id);
$total_downlines = total_downlines($user_id);
$referral_income = referral_income($user_id);
$referral_id = referred_by($user_id);

$user_level = level($user_id);
$level_income = level_income($user_id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
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
                <?php
                $user_upi = user_upi($user_id);
                $name = user_fullname($user_id);
                if (is_empty($user_upi)) {
                ?>
                    <div class="card col-12">
                        <div class="m-0 py-2 row align-items-center justify-content-between">
                            <p style="opacity:0"></p>
                            <h4 class="dash-text py-2 text-center"><?php echo $name; ?>, please complete your profile</h4>
                            <a href="<?php echo $base_url; ?>/profile/" class="py-1 px-2 mr-2 btn btn-secondary">Open</a>
                        </div>
                    </div>
                <?php
                }
                if (is_user_blocked($user_id)) {
                ?>
                    <div class="bg-danger text-white card col-12">
                        <div class="m-0 py-2 row align-items-center justify-content-between">
                            <p style="opacity:0"></p>
                            <h4 class="dash-text py-2 text-center">Your id has blocked please contact customer support</h4>
                            <a href="<?php echo $base_url; ?>/support/" class="py-1 px-2 mr-2 btn btn-secondary">Click Here</a>
                        </div>
                    </div>
                <?php
                }
                ?>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $last_added_money; ?></h2>
                                        <h6 class="text-cyan">Last added Money</h6>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $last_withdrawl_money; ?></h2>
                                        <h6 class="text-cyan">Last Withdrawl Money</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $c_symbol; ?><?php echo $pending; ?></h2>
                                        <h6 class="text-warning">Pending</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-warning display-6"><i class="ti-timer"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $user_level; ?></h2>
                                        <h6 class="text-warning">Level</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-warning display-6"><i class="icon-badge"></i></span>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $level_income; ?></h2>
                                        <h6 class="text-cyan">Level Income</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="mdi mdi-currency-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $active_pins; ?></h2>
                                        <h6 class="text-warning">Active Pin</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-warning display-6"><i class="ti-key"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-warning">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $inactive_pins; ?></h2>
                                        <h6 class="text-warning">Inactive Pin</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-warning display-6"><i class="ti-key"></i></span>
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
                                        <h2><?php echo $total_pins; ?></h2>
                                        <h6 class="text-success">Total Pin</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="ti-key"></i></span>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $expenditure; ?></h2>
                                        <h6 class="text-success">Pin Expenditure</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="ti-receipt"></i></span>
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
                                        <h2><?php echo $left_count; ?></h2>
                                        <h6 class="text-success">Left Count</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="icon-people"></i></span>
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
                                        <h2><?php echo $right_count; ?></h2>
                                        <h6 class="text-success">Right Count</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="icon-people"></i></span>
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
                                        <h2><?php echo $direct_left_count; ?></h2>
                                        <h6 class="text-cyan">Direct Left Count</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="icon-people"></i></span>
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
                                        <h2><?php echo $direct_right_count; ?></h2>
                                        <h6 class="text-cyan">Direct Right Count</h6>
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
                                        <h2><?php echo $total_downlines; ?></h2>
                                        <h6 class="text-cyan">Total downlines</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="icon-vector"></i></span>
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
                                        <h2><?php echo $direct_referral_count; ?></h2>
                                        <h6 class="text-cyan">Direct Referral</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="icon-user-follow"></i></span>
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
                                        <h2><?php echo $c_symbol; ?><?php echo $referral_income; ?></h2>
                                        <h6 class="text-success">Referral Income</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="mdi mdi-currency-usd"></i></span>
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
                                        <h2><?php echo $referral_id; ?></h2>
                                        <h6 class="text-success">Referral Id</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="ti-user"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card  card-hover">
                            <div class="card-header bg-danger">
                                <h4 class="mb-0 text-white">Notice</h4>
                            </div>
                            <div class="card-body">

                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda laboriosam tempore repellat eos vitae esse suscipit, nesciunt repudiandae quis, ut ipsam neque repellendus voluptatibus quia distinctio pariatur natus, commodi officiis quo velit! Atque veniam veritatis iure, eum aliquam doloribus eveniet harum fugiat nostrum iste laudantium expedita omnis, illo quisquam sequi.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda laboriosam tempore repellat eos vitae esse suscipit, nesciunt repudiandae quis, ut ipsam neque repellendus voluptatibus quia distinctio pariatur natus, commodi officiis quo velit! Atque veniam veritatis iure, eum aliquam doloribus eveniet harum fugiat nostrum iste laudantium expedita omnis, illo quisquam sequi.</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>



    </div>
    <?php
    include("../assets/nav/footer.php");
    ?>
</body>

</html>