<?php
include("../db.php");

if (is_admin_loggedin()) {
    header("location:$base_url/admin/dashboard/");
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
                        <img style="max-width:200px" class="img-fluid" src="<?php echo $base_url; ?>/assets/images/web/admin-logo.jpg" alt="">
                    </a>
                </div>
                <div class="text-separator">
                    <span class="text-center card-title">Login</span>
                </div>
                <form id="admin_login_form" class="py-2 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="col-12 mb-3">
                            <label for="validationTooltip02">Username</label>
                            <input value="admin" name="user_id" type="text" class="form-control" placeholder="username or userid" required>
                            <div class="invalid-feedback">
                                Please provide a valid username or userid.
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="validationTooltip02">Password</label>
                            <input value="admin" name="password" type="password" class="form-control" placeholder="password" required>
                            <div class="invalid-feedback">
                                Please provide a valid password.
                            </div>
                        </div>
                        <div class="d-flex col-12 mb-3">
                            <div class="form-check custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="remember_me custom-control-input form-check-input" id="customControlAutosizing">
                                <label class="custom-control-label form-check-label" for="customControlAutosizing">Remember Me</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-primary mt-2" type="submit">Submit</button>
                        <a id="reset_login_form" class="btn text-white text-right btn-primary mt-2">Reset</a>
                    </div>
                </form>
                <div class="d-flex align-items-center col-12 mt-3 p-0">
                    <label class="col-6 p-0">
                        <a style="font-size: .8rem;" class="link" href="<?php echo $base_url; ?>/member/forgot-password.php">Forgot
                            Password?</a>
                    </label>
                    <label class="text-right col-6">
                        <a style="font-size: .8rem;" class="link" href="<?php echo $base_url; ?>/member/register.php">Create Account?</a>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("../assets/nav/footer.php");
    ?>
    <script src="<?php echo  $base_url; ?>/admin/assets/js/dashboard.js"></script>
</body>

</html>