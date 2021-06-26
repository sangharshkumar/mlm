<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$active_tab = 'change-password';
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
                        <h4 class="page-title">Change Password</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
                                <h4 class="card-title">Change Password</h4>
                                <form id="change_password_form" class="needs-validation" novalidate="">

                                    <div class="row form-row mb-3">
                                        <label class="col-sm-3 col-form-label" for="validationCustom1">Current
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="validationCustom1" name="current_password" placeholder="Current Password" value="" required="">
                                            <div class="invalid-feedback">
                                                Please provide a valid current password.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-row mb-3">
                                        <label class="col-sm-3 col-form-label" for="validationCustom2">New Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="validationCustom2" name="new_password" placeholder="New Password" value="" required="">
                                            <div class="invalid-feedback">
                                                Please provide a valid new password.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-row mb-3">
                                        <label class="col-sm-3 col-form-label" for="validationCustom3">Confirm
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="validationCustom3" name="confirm_password" placeholder="Confirm Password" required="">
                                            <div class="invalid-feedback">
                                                Please provide a valid confirm password.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right float-right p-0 m-0 row">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
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