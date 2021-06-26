<?php
include("../db.php");

if (!is_loggedin()) {
   header("location:$base_url");
   exit();
}

$active_tab = 'profile';
$user_id = $loggedin_user_id;

$user_name = user_name($user_id);
$first_name = user_first_name($user_id);
$last_name = user_last_name($user_id);
$user_contact_email = user_email($user_id);
$user_phone = user_phone($user_id);
$user_address = user_address($user_id);
$user_pincode = user_pincode($user_id);
$user_registration_date = user_registration_date($user_id);
$user_referral_id = referred_by($user_id);
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
   <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
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
                  <h4 class="page-title">Edit</h4>
                  <div class="d-flex align-items-center">
                     <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="#">Home</a></li>
                           <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>/profile/">Profile</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
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
                        <ul class="nav nav-tabs">
                           <li class="nav-item">
                              <a style="padding: 10px 20px;font-size:1rem;" href="#profile" class="nav-link active" data-toggle="tab">Profile</a>
                           </li>
                           <li class="nav-item">
                              <a style="padding: 10px 20px;font-size:1rem;" href="#account" class="nav-link" data-toggle="tab">Account Details</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane fade show active" id="profile">
                              <h4 class="pt-4 card-title">Edit Profile Details</h4>
                              <form id="profile_form" class="needs-validation" novalidate="">
                                 <div class="row form-group mb-3">
                                    <label class="col-sm-3 col-form-label">User Id</label>
                                    <div class="col-sm-9 ">
                                       <input readonly type="text" class="  form-control" placeholder="Login Id" value="<?php echo $user_id; ?>" required="">
                                    </div>
                                 </div>
                                 <div class="row form-group mb-3">
                                    <label class="col-sm-3 col-form-label">User Name</label>
                                    <div class="col-sm-9 ">
                                       <input readonly type="text" class="form-control" placeholder="Name" value="<?php echo $user_name; ?>" required="">
                                    </div>
                                 </div>
                                 <div class="row form-group mb-3">
                                    <label class="col-sm-3 col-form-label">Referral Id</label>
                                    <div class="col-sm-9 ">
                                       <input readonly type="text" class="form-control" placeholder="Reference Id" value="<?php echo $user_referral_id; ?>" required="">
                                    </div>
                                 </div>
                                 <div class="row form-group mb-3">
                                    <label class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9 ">
                                       <input type="text" class="alpha-only form-control" name="first_name" placeholder="Name" value="<?php echo $first_name; ?>" required="">
                                       <div class="invalid-feedback"></div>
                                    </div>
                                 </div>
                                 <div class="row form-group mb-3">
                                    <label class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9 ">
                                       <input type="text" class="alpha-only form-control" name="last_name" placeholder="Name" value="<?php echo $last_name; ?>" required="">
                                       <div class="invalid-feedback"></div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                       <input type="text" class="email-only form-control" name="user_email" placeholder="Email" value="<?php echo $user_contact_email; ?>" required="">
                                       <div class="invalid-feedback">
                                          Please provide a valid email.
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                       <div class="input-group">
                                          <div class="input-group-prepend">
                                             <span class="input-group-text" id="inputGroupPrepend3">+</span>
                                          </div>
                                          <input type="text" class="numbers-only form-control" name="phone" value="<?php echo $user_phone; ?>" placeholder="Phone" required="">
                                          <div class="invalid-feedback">
                                             Please provide a valid phone.
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                       <input type="text" class="form-control" name="address" value="<?php echo $user_address; ?>" placeholder="Address" required="">
                                       <div class="invalid-feedback">
                                          Please provide a valid address.
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Pincode</label>
                                    <div class="col-sm-9">
                                       <input type="text" class="numbers-only form-control" name="pincode" value="<?php echo $user_pincode; ?>" placeholder="Pincode" required="">
                                       <div class="invalid-feedback">
                                          Please provide a valid pincode.
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Registration
                                       Date</label>
                                    <div class="col-sm-9">
                                       <input readonly type="text" class="form-control" placeholder="Registration Date" value="<?php echo $user_registration_date; ?>" required="">
                                       <div class="invalid-feedback">
                                          Please provide a valid registration date.
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-row mb-3">
                                    <label class="col-sm-3 col-form-label">Current password</label>
                                    <div class="col-sm-9">
                                       <input type="password" class="form-control" name="password" placeholder="Current password" required="">
                                       <div class="invalid-feedback">
                                          Please provide a valid password.
                                       </div>
                                    </div>
                                 </div>
                                 <div class="text-right float-right p-0 m-0 row">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                 </div>
                              </form>
                           </div>
                           <!-- ACCOUNT TAB START -->
                           <div style="background-color: #f1f3f6 !important;" class="tab-pane fade" id="account">
                              <div class="row justify-content-center">
                                 <div class="bg-white my-4 p-2 col-lg-4 col-sm-12">
                                    <div id="payment_img_upload" class="payment-img-container">
                                       <div style="<?php if ($user_account_image !== $base_url . '/assets/images/users/') {
                                                      echo "display:none";
                                                   }
                                                   ?>" id="pay_upload">
                                          <i class="icon-cloud-upload"></i>
                                          <h4 class="text-center">QR CODE</h4>
                                       </div>
                                       <img id="payimage" class="img-fluid" src="<?php echo $user_account_image; ?>" alt="">
                                    </div>
                                    <form id="user_payment_form" class="resetonload py-2 needs-validation" novalidate="">
                                       <div class="form-row">
                                          <label class="col-lg-12 text-center mt-3 mb-3 ">
                                             <h2>OR</h2>
                                          </label>
                                          <div class="col-12 mb-3">
                                             <label>Phone Pay/ Paytm Id/ Google Pay</label>
                                             <input value="<?php echo $user_account_number; ?>" name="account_number" type="text" maxlength="10" class="form-control" placeholder="Number">
                                          </div>
                                          <label class="col-lg-12 text-center m-0">
                                             <h2>OR</h2>
                                          </label>
                                          <div class="col-12 mb-3">
                                             <label>Upi Id</label>
                                             <input value="<?php echo $user_upi; ?>" name="user_upi" type="text" class="form-control" placeholder="upi@ybl">
                                          </div>
                                          <div class="col-12 mb-3">
                                             <label>Current Password</label>
                                             <input name="current_password" type="text" class="form-control" placeholder="Current Password" required="">
                                             <div class="invalid-feedback">Please provide a valid current password.</div>
                                          </div>
                                       </div>
                                       <div class="text-right float-right p-0 m-0 row">
                                          <button class="btn btn-primary" type="submit">Submit</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <!-- ACCOUNT TAB START -->
                        </div>
                     </div>
                  </div>
               </div>
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
                     <button type="button" class="btn btn-primary ml-1" id="savepaymentimg">Save</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php
   include("../assets/nav/footer.php");
   ?>
   <script src="<?php echo $base_url; ?>/assets/js/cropper.js"></script>
</body>

</html>