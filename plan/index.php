<?php
include("../db.php");
$active_tab = 'support';
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$user_id = $loggedin_user_id;
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
                        <h4 class="page-title">Plan</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Plan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="al-pricing container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card al-price-box">
                            <div class="al-pricing-header card-header text-center px-5 pt-5 pb-0">
                                <i style="font-size:200px" class=" icon-info "></i>
                                <h4 class="al-pricing-title my-0 font-weight-bold">Free</h4>
                                <h1 class="card-title al-pricing-price mt-2 mb-0"><?php echo $c_symbol; ?>10 </h1>
                            </div>
                            <div class="card-body al-pricing-features">
                                <ul class="list-unstyled mb-4">
                                    <strong>
                                        <li>Level 1 : <?php echo $c_symbol; ?>20</li>
                                    </strong>
                                    <strong>
                                        <li>Level 2 : <?php echo $c_symbol; ?>40</li>
                                    </strong>
                                    <strong>
                                        <li>Level 3 : <?php echo $c_symbol; ?>100<span class="text-muted"></span></li>
                                    </strong>
                                </ul>
                                <a href="<?php echo $base_url; ?>/pin/" type="button" class="btn btn-primary btn-lg btn-block font-weight-bold">Subscribe Now</a>
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