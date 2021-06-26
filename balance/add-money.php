<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

if (is_user_blocked($loggedin_user_id)) {
   header("location:$block_page");
   exit();
}

$page_tab = 'balance';
$active_tab = 'add-money'

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
                        <h4 class="page-title">Add Money</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Balance</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Money</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <img src="<?php echo $base_url; ?>/assets/images/web/paytm.png" class="card-img-top" alt="image">
                            <div class="card-body">
                                <h5 class="card-title">All payment accepted - INR</h5>
                                <hr>
                                <a class="text-white btn btn-primary" data-toggle="modal" data-target="#paytmModal">Add Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="paytmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add amount with paytm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="add_amount_form" class="py-2 resetonload">
                                    <div style="max-width:500px" class="modal-body">
                                        <div class="form-row">
                                            <div class="col-12 mb-3">
                                                <label>Enter Amount</label>
                                                <input id="amount" maxlength="7" name="amount" type="text" class="numbers-only form-control" placeholder="Amount to add" required="">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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