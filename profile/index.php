<?php
include("../db.php");
$active_tab = 'profile';
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$user_id = $loggedin_user_id;
$user_email = user_email($user_id);
$user_name = user_name($user_id);
$user_fullname = user_fullname($user_id);
$user_phone = user_phone($user_id);
$user_address = user_address($user_id);
$user_pin_code = user_pincode($user_id);
$user_registration_date = user_registration_date($user_id);
$user_account_number = user_account_number($user_id);
$user_upi = user_upi($user_id);
$user_account_image = user_account_image($user_id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/cropper.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <h4 class="page-title">Profile</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row myprofile-card-wrapper">
                    <!-- Column -->
                    <div class="myprofile-card col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Change your profile</h4>
                                <div class="profile_img_container">
                                    <div id="img_upload" class="img_center">
                                        <img style="width:100%" id="avatarimage" src="<?php echo user_image($user_id); ?>" alt="">
                                        <div class="upload_container">
                                            <div class="img_layer">
                                            </div>
                                            <div class="hover_icon"><img src="<?php echo $base_url; ?>/assets/images/web/upload.png"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-information">
                                    <a href="<?php echo $base_url; ?>/profile/edit.php"><img class="edit_data" src="<?php echo $base_url; ?>/assets/images/web/pencil.svg"></a>
                                    <label class="text-center"><b>Profile Details</b></label>
                                    <div class="information-data-row">
                                        <div>
                                            <span>User Id</span>
                                            <span><?php echo $user_id; ?></span>
                                        </div>
                                        <div>
                                            <span>User Name</span>
                                            <span><?php echo $user_name; ?></span>
                                        </div>
                                        <div>
                                            <span>Email</span>
                                            <span><?php echo $user_email; ?></span>
                                        </div>
                                        <div>
                                            <span>Full Name</span>
                                            <span><?php echo $user_fullname; ?></span>
                                        </div>
                                        <div>
                                            <span>Phone</span>
                                            <span>+<?php echo $user_phone; ?></span>
                                        </div>
                                        <div>
                                            <span>Address</span>
                                            <span><?php echo $user_address; ?></span>
                                        </div>
                                        <div>
                                            <span>Pincode</span>
                                            <span><?php echo $user_pin_code; ?></span>
                                        </div>
                                        <div>
                                            <span>Registration Date</span>
                                            <span class="re-date"><?php echo $user_registration_date; ?></span>
                                        </div>
                                    </div>
                                    <label class="text-center pt-2" style="border-top: 1px solid #dadbdd;"><strong>Account Details</strong></label>
                                    <div class="information-data-row">

                                        <div>
                                            <span class="re-date">Phone Pay/ Paytm Id/ Google Pay Id</span>
                                            <span class="re-date"><?php echo $user_account_number; ?></span>
                                        </div>
                                        <div>
                                            <span>UPI</span>
                                            <span><?php echo $user_upi; ?></span>
                                        </div>
                                        <div>
                                            <span>QR Code</span>
                                            <span><img src="<?php echo $user_account_image; ?>" alt=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
            </div>



        </div>




        <!-- The Make Selection Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Make a selection</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="cropimage">
                            <img id="imageprev" src="" />
                        </div>

                        <div style="display:none" class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="col-12 row justify-content-between btngroup">
                            <div class="d-flex">
                                <button type="button" class="btn btnsmall" id="rotateL" title="Rotate Left">
                                    <i class="fas fa-undo"></i></button>
                                <button type="button" class="btn btnsmall" id="rotateR" title="Rotate Right">
                                    <i class="fas fa-repeat"></i>
                                </button>
                                <button type="button" class="btn btnsmall" id="scaleX" title="Flip Horizontal">
                                    <i class="fa fa-arrows-h"></i>
                                </button>
                                <button type="button" class="btn btnsmall" id="scaleY" title="Flip Vertical">
                                    <i class="fa fa-arrows-v"></i>
                                </button>
                                <button type="button" class="btn btnsmall" id="reset" title="Reset">
                                    <i class="fas fa-refresh"></i>
                                </button>
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary ml-1" id="saveAvatar">Save</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- The Camera Modal -->
        <div class="modal" id="cameraModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Take a picture</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="my_camera"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn upload" data-dismiss="modal">Close</button>
                        <button type="button" class="btn camera" id="spanshot">Take a picture</button>
                    </div>

                </div>
            </div>
        </div>
        <?php
        include("../assets/nav/footer.php");
        ?>
        <script src="<?php echo $base_url; ?>/assets/js/dropzone.js"></script>
        <script src="<?php echo $base_url; ?>/assets/js/webcam.min.js"></script>
        <script src="<?php echo $base_url; ?>/assets/js/cropper.js"></script>
</body>

</html>