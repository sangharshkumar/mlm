<?php
include("../db.php");

if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$user_id = $loggedin_user_id;
$active_tab = 'refer-link';
$my_referral_link = $base_url . '/member/register.php?referral_id=' . $user_id;
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
                        <h4 class="page-title">Referral Link</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Referral Link</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">My referral link</h4>
                                <div class="row py-4 form-group">
                                    <div class="col-sm-12 pb-2 col-md-8">
                                        <input type="text" class="form-control" value="<?php echo $my_referral_link; ?>">
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <button style="float: right;" id="copy_my_referral_link" class="btn btn-success">Copy Link</button>
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
    include("../assets/nav/footer.php");
    ?>


    <script>
        var my_referral_link = '<?php echo $my_referral_link; ?>';
    </script>
</body>

</html>