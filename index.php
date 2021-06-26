<?php
include("db.php");
if (is_loggedin()) {
    header("location:$base_url/dashboard/");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>

<body>
    <section class="hero-section" style="background: url(<?php echo $base_url; ?>/assets/images/web/home.png);">
        <h1 class="contact" >Create your MLM Software <a class="contact-btn" href="https://api.whatsapp.com/send?phone=+919771701893" class="btn-login btn">Contact</a></h1>
        <div class="hero-area">
            <div id="particles-js"><canvas class="particles-js-canvas-el" style="width: 100%; height: 100%;"></canvas></div>
            <div class="single-hero">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-11 text-center">
                            <div class="hero-sub">
                                <div class="table-cell">
                                    <div class="pt-5 hero-left">
                                        <h4>Binary Multi Level Marketing</h4>
                                        <h1>Intelligent Plan for your Money</h1>
                                        <p>We are a certified leading company in Binary Multi-Level Marketing business. Be a part of our community today by investing your money and getting a good profit form us.</p>
                                        <a href="<?php echo $base_url; ?>/member/register.php" class="btn-register btn"><i class="mr-2  icon-user "></i>Register</a>
                                        <a href="<?php echo $base_url; ?>/member/login.php" class="btn-login btn"><i class="mr-2  icon-login "></i>Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white text-dark">
        <h2 class="text-center"> Why Choose us </h2>
        <h5 class="text-center"> Our goal is to provide our clients a good profit for their investments while ensuring them safe and secure transactions. </p>
        <div class=" col-12">
        <div class="row">

            <div class="choose-box col-lg-4 col-sm-12">
                <div class="py-4 bg-success card text-center text-white">
                    <div class="card-body">
                        <i class="fas fa-hands-helping"></i>
                        <h3 class="mb-2 ">24/7 Support</h3>
                        <p>We are here for you. We provide 24/7 customer support through e-mail.</p>
                    </div>
                </div>
            </div>

            <div class="choose-box col-lg-4 col-sm-12">
                <div class="py-4 bg-success card text-center text-white">
                    <div class="card-body">
                        <i class="mdi mdi-currency-usd"></i>
                        <h3 class="mb-2 ">Quick Withdrawal</h3>
                        <p>Our site has a high maximum limit of withdrawal which is performed in seconds.</p>
                    </div>
                </div>
            </div>

            <div class="choose-box col-lg-4 col-sm-12">
                <div class="py-4 bg-success card text-center text-white">
                    <div class="card-body">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h3 class="mb-2 ">Profitable</h3>
                        <p>Easily get profit for adding members. Easy to make money and withdraw within minutes.</p>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>

    <section class="work-section py-5 text-white">
        <h2 class="text-center"> How It Work </h2>
        <p class="text-center"> Get involved with our community today and get profit in your wallet automatically. </p>
        <div class="row col-12">

            <div class="work-box col-lg-4 col-sm-12">
                <div class="card py-4 text-center">
                    <div class="card-body">
                        <i class="icon-user-following "></i>
                        <h3 class="mb-2 ">Sign up</h3>
                        <p>Signup using few easy steps and get started with us.</p>
                    </div>
                </div>
            </div>

            <div class="work-box col-lg-4 col-sm-12">
                <div class="card py-4 text-center">
                    <div class="card-body">
                        <i class=" icon-user-follow "></i>
                        <h3 class="mb-2 ">Add member</h3>
                        <p>Add more members using your referral.</p>
                    </div>
                </div>
            </div>

            <div class="work-box col-lg-4 col-sm-12">
                <div class="card py-4 text-center">
                    <div class="card-body">
                        <i class="icon-wallet"></i>
                        <h3 class="mb-2 ">Get Profit</h3>
                        <p>Get profited from us which is easy to withdraw.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <footer class="py-5">
        <div class="pt-5 container text-center">
            <p>We are a certified leading company in Binary Multi-Level Marketing (MLM) business. Be a part of our community today by investing your money and getting a good profit form us.</p>

            <div class="pt-5 pb-5 social">
                <a href="https://jamsrworld.com" title="Linkedin">
                    <i class="fab fa-linkedin-in"></i> </a>
                <a href="https://jamsrworld.com" title="Youtbe">
                    <i class="fab fa-youtube"></i> </a>
                <a href="https://jamsrworld.com" title="Facebok">
                    <i class="fab fa-facebook"></i> </a>
            </div>

            <!-- <p>Copyright © 2021 - Jamsrworld. All Rights Reserved.</p> -->
            <p>Copyright © 2021 - <a class="link" href="https://jamsrworld.com">Jamsrworld.com</a> All Rights Reserved.</p>
        </div>
    </footer>

    <script src="<?php echo $base_url; ?>/assets/js/particles.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/particle-app.js"></script>
</body>

</html>