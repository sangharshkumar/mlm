<?php
include("../db.php");
$active_tab = 'total-team';
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$user_id = $loggedin_user_id;

$left_count = left_count($user_id);
$right_count = right_count($user_id);
$a = direct_all_referral_id($user_id);
$direct_left_count = $a['direct_left_count'];
$direct_right_count =  $a['direct_right_count'];
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
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                                        <span class="text-cyan display-6"><i class="icon-user-follow"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div style="border:5px;" class="card border-bottom border-cyan">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><?php echo $direct_right_count; ?></h2>
                                        <h6 class="text-cyan">Direct Right Count</h6>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-cyan display-6"><i class="icon-user-follow"></i></span>
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
                                                <th>Serial No.</th>
                                                <th>User Name</th>
                                                <th>User Id</th>
                                                <th>Referral Id</th>
                                                <th>Level</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo show_total_team($user_id); ?>
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
            $('#data_table').DataTable();
        });
    </script>
</body>

</html>