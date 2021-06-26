<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$page_tab = 'balance';
$active_tab = 'withdraw'
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
                        <h4 class="page-title">Withdraw</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Balance</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Withdraw</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">

                    <div id="withdraw_amount_container" class="col-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="py-2 card">
                                        <div class="card-body">
                                            <h4 class="card-title">Withdraw Money</h4>
                                            <form id="withdraw_amount_form" class="py-2 resetonload">
                                                <div class="form-row">
                                                    <div class="col-12 mb-3">
                                                        <label>Enter Amount</label>
                                                        <input id="withdraw_amount_input" name="amount" type="text" class="numbers-only form-control" placeholder="Amount to withdraw" required="">
                                                        <div class="invalid-feedback">
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

                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="card">

                                    <div class="card-body bg-success" style="padding: .8rem;">
                                        <h4 class="m-0 text-white card-title">Preview</h4>
                                    </div>
                                    <input type="hidden" name="_token" value="PxXvzFuas9I9qpIso8FzR9AhKh0XFcddGoDLCAy9"> <input type="hidden" name="gateway" value="">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Amount : </strong><span id="amt_pre_txt" class="badge badge-primary">0 INR</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Admin charge (5%) : </strong><span id="chr_pre_txt" class="badge badge-danger">0 INR</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Charge less than <?php echo $c_symbol; ?>100 :</strong><span id="admin_chr_pre_txt" class="badge badge-danger">0 INR</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Recieve amount :</strong> <span id="rec_amt_pre_txt" class="badge badge-success">0 INR</span>
                                        </li>

                                    </ul>
                                </div>
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