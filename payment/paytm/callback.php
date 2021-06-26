<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";
$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);

include("../../db.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $web_name; ?></title>
</head>
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/payment.css">

<body class="jumbotron">

    <?php
    if ($isValidChecksum != "TRUE") {
    ?>
        <div class="container">
            <div class="page_content">
                <img src="<?php echo $base_url; ?>/assets/images/web/warning.png" alt="">
                <h2>Checksum mismatched</h2>
                <p>Process transaction is suspicious. Someone altered the transaction details.If you have any problem feel free to contact us at <a class="link" href="mailto:support@jamsrworld.com">support@jamsrworld.com</a><br>Regards,<br>Jamsr World </p>
                <a class="btn" href="<?php echo $base_url; ?>">Home</a>
            </div>

        </div>
        <?php
        exit();
    }

    if ($isValidChecksum == "TRUE") {
        if ($_POST["STATUS"] == "TXN_SUCCESS") {
            $order_id = $_POST['ORDERID'];
            $query = mysqli_query($conn, "SELECT * FROM $payment_tbl WHERE order_id = '$order_id' ");
            if (!mysqli_num_rows($query)) {
                echo "Something went wrong";
                exit();
            }
            $db_payment_data = mysqli_fetch_array($query);
            $db_status = $db_payment_data['status'];
            $payer_user_id = $db_payment_data['payer_user_id'];


            $paid_amount = $_POST['TXNAMOUNT'];
            $status = $_POST['STATUS'];
            $txn_date = $_POST['TXNDATE'];
            mysqli_query($conn, "UPDATE $payment_tbl SET paid_amount = '$paid_amount', payment_date = '$txn_date', status = '$status' WHERE order_id = '$order_id'   ");



            if ($db_status === 'inactive') {
                $txn_date = strtotime($txn_date);
                $query = mysqli_query($conn, "SELECT * FROM $balance_tbl WHERE user_id = '$payer_user_id' ");
                mysqli_query($conn, "UPDATE $balance_tbl SET wallet = wallet + $paid_amount, last_added_money = '$paid_amount', total_added_money = total_added_money + '$paid_amount'  WHERE user_id = '$payer_user_id' ");
                mysqli_query($conn, "INSERT INTO $transaction_tbl ( `user_id`, `amount`, `transaction_charge`, `net_amount`, `description`,`category`, `date`, `status`)
                 VALUES('$payer_user_id','$paid_amount','0.00','$paid_amount','credit by paytm','deposit','$txn_date','credit') ");
                 mysqli_query($conn,"INSERT INTO $deposit_tbl (`user_id`, `amount`, `payment_method`, `date`) VALUES ('$payer_user_id','$paid_amount','paytm','$txn_date') ");
            }


        ?>
            <div class="container">
                <div class="page_content">
                    <img src="<?php echo $base_url; ?>/assets/images/web/success.png" alt="">
                    <h2>Thanks</h2>
                    <p>Your transation has been successfully processed.If you have any problem feel free to contact us at <a class="link" href="mailto:support@jamsrworld.com">support@jamsrworld.com</a>.<br> Regards, Jamsr World</p>
                    <?php
                    $i = 0;
                    if (isset($_POST) && count($_POST) > 0) {
                        foreach ($_POST as $paramName => $paramValue) {
                            $i++;
                            if ($i == 1 || $i == 4 || $i == 6 || $i == 8 || $i == 7 || $i == 9 || $i == 11 || $i == 13) {
                                echo '<div><b>' . $paramName . '</b> <p>' . $paramValue . '</p></div>';
                                continue;
                            }
                        }
                    } ?>
                    <a class="btn" href="<?php echo $base_url; ?>">Home</a>
                </div>

            </div>


        <?php
            exit();
        } else {
        ?>
            <div class="container">
                <div class="page_content">
                    <img src="<?php echo $base_url; ?>/assets/images/web/warning.png" alt="">
                    <h2>Transaction Failed</h2>
                    <p>Your transation has been failed.If you have any problem feel free to contact us at <a class="link" href="mailto:support@jamsrworld.com">support@jamsrworld.com</a><br>Regards,Jamsr World </p>
                    <?php
                    if (isset($_POST) && count($_POST) > 0) {
                        $order_id = $_POST['ORDERID'];
                        $query = mysqli_query($conn, "SELECT * FROM $payment_tbl WHERE order_id = '$order_id' ");
                        $status = $_POST['STATUS'];
                        mysqli_query($conn, "UPDATE $payment_tbl SET status='$status' WHERE order_id = '$order_id' ");
                        echo '<div><b>ORDERID</b> <p>' . $_POST['ORDERID'] . '</p></div>';
                        echo '<div><b>RESPCODE</b> <p>' . $_POST['RESPCODE'] . '</p></div>';
                        echo '<div><b>RESPMSG</b> <p>' . $_POST['RESPMSG'] . '</p></div>';
                        echo '<div><b>STATUS</b> <p>' . $_POST['STATUS'] . '</p></div>';
                        echo '<div><b>TXNAMOUNT</b> <p>' . $_POST['TXNAMOUNT'] . '</p></div>';
                        echo '<div><b>CURRENCY</b> <p>' . $_POST['CURRENCY'] . '</p></div>';
                    }
                    ?>
                    <a class="btn" href="<?php echo $base_url; ?>">Home</a>
                </div>

            </div>
    <?php
        }
    }
