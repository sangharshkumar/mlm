<?php
include("../db.php");
if (is_loggedin()) {
    header("location:$base_url");
    exit();
}

$token = $_GET['token'];

if (!is_member_token_valid($token)) {
    header("location:$error_page");
    exit();
}

?>

<script>
    var token = '<?php echo $token; ?>';
</script>

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
        <div style="max-width:400px !important;" class="shadow my-4 py-3 card col-sm-12 col-md-8">
            <div class="card-body">
                <div class="mb-2 text-center">
                    <a href="<?php echo $base_url; ?>">
                        <img src="<?php echo $base_url; ?>/assets/images/web/logo-icon.png" alt="">
                        <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-text.png" alt="">
                    </a>
                </div>
                <div class="text-separator">
                    <span class="text-center card-title">Reset Password</span>
                </div>
                <form id="reset_password_form" class="py-2 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="col-12 mb-3">
                            <label for="validationTooltip02">New Password</label>
                            <input name="password" type="text" class="form-control" placeholder="New Password" required>
                            <div class="invalid-feedback">
                                Please provide a valid password.
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="validationTooltip02">Confirm New Password</label>
                            <input name="confirm_password" type="text" class="form-control" placeholder="Confirm New Password" required>
                            <div class="invalid-feedback">
                                Please provide a valid confirm password.
                            </div>
                        </div>
                    </div>
                    <div class="text-right float-right p-0 m-0 row">
                        <button class="btn btn-primary mt-2" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include("../assets/nav/footer.php");
    ?>
</body>

</html>