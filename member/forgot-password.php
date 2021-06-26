<?php
include("../db.php");
if (is_loggedin()) {
    header("location:$base_url");
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
</head>

<body page="member">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="page-wrapper container-fluid d-flex h-100 min-vh-100 justify-content-center align-items-center">
        <div style="max-width:400px !important;" class="shadow m-3 py-3 card col-sm-12 col-md-8">
            <div class="card-body">
                <div class="mb-2 text-center">
                    <a href="<?php echo $base_url; ?>">
                        <img src="<?php echo $base_url; ?>/assets/images/web/logo-icon.png" alt="">
                        <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-text.png" alt="">
                    </a>
                </div>
                <div class="text-separator">
                    <span class="text-center card-title">Forgot Password</span>
                </div>
                <form id="forgot_password_form" class="py-2 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="col-12 mb-3">
                            <label for="validationTooltip02">User Id</label>
                            <input name="user_id" type="text" class="form-control" placeholder="username or userid" required>
                            <div class="invalid-feedback">
                                Please provide a valid username or userid.
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right float-right p-0 m-0 row">
                        <button class="btn btn-primary mt-2" type="submit">Submit</button>
                    </div>
                </form>
                <div class="d-flex col-12 mt-3 p-0">
                    <label class="d-flex col-12 p-0">
                        Remember Password? <a class="link" href="<?php echo $base_url; ?>/member/login.php">Login</a>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("../assets/nav/footer.php");
    ?>
</body>

</html>