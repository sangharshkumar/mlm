<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'total-team';
$page_tab = 'genealogy' ;

if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


if (isset($_GET['user'])) {
    if (is_user_id($_GET['user'])) {
        $admin_id = $_GET['user'];
    }
}

$left_count = left_count($admin_id);
$right_count = right_count($admin_id);
$total_team_count = total_team_count();
$active_team_count = active_team_count();
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
                        <h4 class="page-title">Total Team</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Genealogy</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Total Team</li>
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
                                        <h2><?php echo $left_count; ?></h2>
                                        <h6 class="text-success">Left Team</h6>
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
                                        <h6 class="text-success">Right Team</h6>
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
                                        <h2><?php echo $total_team_count; ?></h2>
                                        <h6 class="text-success">Total Team</h6>
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
                                        <h2><?php echo $active_team_count; ?></h2>
                                        <h6 class="text-success">Active Team</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-success display-6"><i class="icon-people"></i></span>
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
                            <div class="row align-items-center">
                                        <div class="col-6">
                                            <h4 class="card-title">Total Team Summary</h4>
                                        </div>
                                    </div>
                                <div class="table-responsive">
                                    <table class="table product-overview" id="data_table">
                                        <thead>
                                            <tr>
                                                <?php
                                                if (isset($_GET['user'])) {
                                                    $user_id = $_GET['user']; ?>
                                                    <th>Serial No.</th>
                                                <th>User Name</th>
                                                <th>User Id</th>
                                                <th>Referral Id</th>
                                                <th>Level</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <th>Serial No.</th>
                                                    <th>User Name</th>
                                                    <th>User Id</th>
                                                    <th>Email</th>
                                                    <th>Level</th>
                                                    <th>Referral Id</th>
                                                    <th>Registration Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                <?php
                                                }

                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_GET['user'])) {
                                                $user_id = $_GET['user'];
                                                show_total_team($user_id);
                                            } else {
                                                echo total_team("");
                                            }
                                            ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <?php
    include("../../assets/nav/footer.php");
    ?>
    <script src="<?php echo $base_url;?>/admin/assets/js/dashboard.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/datatable.min.css">
    <script src="<?php echo $base_url; ?>/assets/js/datatable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
        //fix menu overflow under the responsive table 
// hide menu on click... (This is a must because when we open a menu )
$(document).click(function (event) {
    //hide all our dropdowns
    $('.dropdown-menu[data-parent]').hide();

});
    </script>
</body>

</html>