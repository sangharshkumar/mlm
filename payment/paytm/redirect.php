<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// Include database
include("../../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$user_id = $loggedin_user_id;

if (!isset($_GET['amount'])) {
    header("location:$error_page");
    exit();
}

$payable_amount = $_GET['amount'];
$payable_amount =  preg_replace("/[^0-9]/", '', $payable_amount);

if (is_empty($payable_amount)) {
    header("location:$base_url");
    exit();
}

// if ($payable_amount < 20) {
//     echo "Minimum amount is Rs 20";
//     exit();
// }

// if ($payable_amount > 10000) {
//     echo "Maximum amount is Rs 1000";
//     exit();
// }


// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$checkSum = "";
$paramList = array();

$ORDER_ID = "ORDS" . rand(10000000, 99999999);
$CUST_ID = "CUST" . rand(10000000, 99999999);
$INDUSTRY_TYPE_ID = 'Retail';
$CHANNEL_ID = 'WEB';
$TXN_AMOUNT = $payable_amount;

// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
$paramList["CALLBACK_URL"] = $base_url . '/payment/paytm/callback';
$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
$query = mysqli_query($conn, "SELECT * FROM $payment_tbl WHERE order_id = '$ORDER_ID' ");
if (mysqli_num_rows($query)) {
    $ORDER_ID = "ORDS" . rand(10000099, 99999999);
}

$query = mysqli_query($conn, "INSERT INTO $payment_tbl (`payer_user_id`, `order_id`, `payable_amount`, `paid_amount`, `payment_date`, `status`)
                     VALUES ('$user_id','$ORDER_ID','$payable_amount','','','inactive') ");

if (!$query) {
    echo "Something went wrong";
    exit();
}

?>

<html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $web_name; ?></title>

<body>

    <div class="alert alert-success" style="margin-top:20px;">
        <strong>Warning!</strong> Please do not refresh this page...
    </div>

    <ul style="display:none;" class="list-group">
        <form method="POST" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
            <?php
            foreach ($paramList as $name => $value) {
                echo '<input style="display:none;" readonly type="hidden" name="' . $name . '" value="' . $value . '">';
            }
            ?>
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
            <script src="<?php echo $base_url; ?>/assets/js/jquery.min.js"></script>
            <script type="text/javascript">
                document.f1.submit();
                $(document).on('mousehover focus mousein blur', function() {
                    $('ul').hide();
                });
            </script>
        </form>
    </ul>

</body>

</html>