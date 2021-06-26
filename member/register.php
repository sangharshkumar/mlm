<?php
include("../db.php");
if (isset($_GET['referral_id'])) {
    $id = $_GET['referral_id'];
    if (is_user_id($id)) {
        $referral_id = $id;
        $data = user_tree_data($referral_id);
        $left_id = $data['left_id'];
        $right_id = $data['right_id'];
        if ($left_id == 0 || $right_id == 0) {
            $placement_id = $referral_id;
        }
    }
}

if (isset($_GET['r_id'], $_GET['p_id'], $_GET['p_t'])) {

    if (is_user_id($_GET['r_id'])) {
        $referral_id = $_GET['r_id'];
    }

    if (is_user_id($_GET['r_id'])) {
        $placement_id = $_GET['p_id'];
    }

    $placement = $_GET['p_t'];
    if ($placement == 'l') {
        $placement_type = 'left';
    }
    if ($placement == 'r') {
        $placement_type = 'right';
    }
}

if (isset($referral_id)) {
    $referral_user_name = user_name($referral_id);
}

if (isset($placement_id)) {
    $placement_user_name = user_name($placement_id);
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
<style>
    .form-group {
        margin: 0 !important;
    }

    .select-styled.is-valid-select {
        border: 1px solid #36bea6;
        padding-right: calc(1.5em + .75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2336bea6' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
        border-radius: 2px;
    }
</style>

<body page="member">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="page-wrapper container-fluid d-flex h-100 min-vh-100 justify-content-center align-items-center">
        <div style="max-width:800px;" class="shadow my-4 py-4 card col-12">
            <div class="card-body">
                <div class="mb-2 text-center">
                    <a href="<?php echo $base_url; ?>">
                        <img src="<?php echo $base_url; ?>/assets/images/web/logo-icon.png" alt="">
                        <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-text.png" alt="">
                    </a>
                </div>
                <div class="text-separator">
                    <span class="text-center card-title">Register</span>
                </div>
                <form id="registration_form" class="py-2">
                    <div class="form-row">
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>Referral Id</label>
                                <input value="<?php if (isset($referral_id)) {
                                                    echo $referral_id;
                                                } ?>" name="referral_id" id="referral_id" type="text" class="numbers-only form-control" placeholder="Referral Id" required>
                                <div class="invalid-feedback">
                                    Please provide a valid referral id.
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Referral Name</label>
                                <input disabled value="<?php if (isset($referral_id)) {
                                                            echo $referral_user_name;
                                                        } ?>" id="referral_name" type="text" class=" form-control" placeholder="Referral Name" required>
                                <div class="valid-feedback">

                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>Placement Id</label>
                                <input value="<?php if (isset($placement_id)) {
                                                    echo $placement_id;
                                                } ?>" id="placement_id" name="placement_id" type="text" class="numbers-only form-control" placeholder="Placement Id" required>
                                <div class="invalid-feedback">
                                    Please provide a valid placement id
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Placement User Name</label>
                                <input disabled value="<?php if (isset($placement_id)) {
                                                            echo $placement_user_name;
                                                        } ?>" id="placement_name" disabled type="text" class="form-control" placeholder="Placement User Name" required>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="cs-flex col-md-6 mb-3">
                                <label>Placement Type</label>
                                <select id="placement_type" required class="form-control" id="">
                                    <option value="hide">Select Placement Type</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid placement type.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Referral Pin</label>
                                <input id="referral_code" name="referral_code" maxlength="8" type="text" class="form-control" placeholder="Referral Pin" required>
                                <div class="invalid-feedback">
                                    Please provide a valid referral pin .
                                </div>
                                <div class="valid-feedback">
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input id="first_name" name="first_name" type="text" class="alpha-only form-control" placeholder="First Name" required>
                                <div class="invalid-feedback">
                                    Please provide a valid first name.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input name="last_name" type="text" class="alpha-only form-control" placeholder="Last Name" required>
                                <div class="invalid-feedback">
                                    Please provide a valid last name.
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>Username</label>
                                <input id="user_name" name="user_name" type="text" class="alphanumeric-only form-control" placeholder="Username" required>
                                <div class="invalid-feedback">
                                    Please provide a valid username.
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile Number</label>
                                <div class="input-group" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">+</span>
                                                </div>
                                <input id="mobile_number" name="mobile_number" maxlength="13" type="text" class="numbers-only form-control" placeholder="91 1234567890" required>
                                <div class="invalid-feedback">
                                    Please provide a valid mobile number.
                                </div>
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input id="email" name="email" type="email" class="email-only form-control" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                                <div class="valid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Enter Otp</label>
                                <div class="input-group">
                                    <input id="otp" name="otp" type="text" maxlength="5" class="numbers-only form-control" placeholder="Enter Otp" required>
                                    <div class="input-group-append">
                                        <button id="send_otp" class="btn btn-info" type="button">Send</button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide a valid username.
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <!--  -->
                        <div class="col-12 row form-group">
                            <div class="col-md-6 mb-3">
                                <label>Password</label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid password.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirm Password</label>
                                <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" required>
                                <div class="invalid-feedback">
                                    Please provide a valid confirm password.
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div style="padding:0 15px;" class="m-0 row justify-content-between col-12 mb-3">
                            <div class="col-12 col-sm-8 form-check custom-control custom-checkbox ">
                                <input required type="checkbox" class="remember_me custom-control-input form-check-input" id="customControlAutosizing">
                                <label class="custom-control-label form-check-label" for="customControlAutosizing">Agree Jamsr's term & conditions.</label>
                            </div>
                            <label class="col-12 col-sm-4 text-right">
                                <a class="link" href="<?php echo $base_url; ?>/member/login.php">Log In?</a>
                            </label>
                        </div>
                    </div>
                    <div class="text-right float-right p-0 m-0 row">
                        <button class="ml-2 btn btn-primary mt-2" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include("../assets/nav/footer.php");




    if (isset($referral_id)) {
    ?>
        <script>
            $('#referral_id').removeClass('is-invalid').addClass('is-valid').siblings('.valid-feedback').html('Referal id matched');
            $('#referral_name').removeClass('is-invalid').addClass('is-valid');
        </script>
        <?php
        $referral_user_name = user_name($referral_id);
    }

    if (isset($placement_id)) {
        $data = user_tree_data($placement_id);
        $left_id = $data['left_id'];
        $right_id = $data['right_id'];
        if ($left_id != 0 && $right_id != 0) {
        ?>
            <script>
                $("#placement_id").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').html('left and right both id is in use');
            </script>
        <?php
        } else {
        ?>
            <script>
                $("#placement_id").removeClass('is-invalid').addClass('is-valid').siblings('.valid-feedback').html('Placement id matched');
                $('#placement_name').removeClass('is-invalid').addClass('is-valid');
            </script>
        <?php
        }
        if ($left_id != 0) {
        ?>
            <script>
                $("ul.select-options li[rel=left]").addClass('disabled');
            </script>
        <?php
        }
        if ($right_id != 0) {
        ?>
            <script>
                $("ul.select-options li[rel=right]").addClass('disabled');
            </script>
        <?php
        }
    }

    if (isset($placement_id, $placement_type)) {
        $data = user_tree_data($placement_id);
        $left_id = $data['left_id'];
        $right_id = $data['right_id'];
        if ($placement_type == 'left' && $left_id == 0) {
        ?>
            <script>
                $('.select-styled').html('Left');
            </script>
        <?php
        }

        if ($placement_type == 'right' && $right_id == 0) {
        ?>
            <script>
                $('.select-styled').html('Right');
            </script>
    <?php
        }
    }

    ?>



</body>

</html>