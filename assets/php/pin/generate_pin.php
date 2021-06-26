<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}
if (!is_loggedin()) {
    echo "Login to generate pin";
    exit();
}

if (!isset($_POST['pin_count'])) {
   echo "Something is missing";
   exit();
}

if(is_user_blocked($loggedin_user_id)){
   echo "You id has blocked please contact customer support";
   exit();
}

$pincount = $_POST['pin_count'];
if (is_empty($pincount)) {
    echo "Pin count is empty";
    exit();
}

if (!ctype_digit($pincount)) {
    echo "Only numbers are allowed";
    exit();
}

if($pincount > 10 ){
    echo "Maximum 10 pins are allowed";
    exit();
}

$pinstrlength = strlen($pincount);

if ($pinstrlength > 2) {
   echo "Something went wrong";
   exit();
}

$each_pin_count = '49.00';
$total_pin_cost = $pincount * $each_pin_count;
$wallet = wallet($loggedin_user_id);
if ($total_pin_cost > $wallet) {
   echo "Insufficient amount to buy $pincount pins";
   exit();
}

for ($i = $pincount; $i > 0; $i--) {
    $pin =  random_strings(8);
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin = '$pin' ");
    if (mysqli_num_rows($query)) {
        $pin = random_strings(8);
    }

    $query = mysqli_query($conn, "INSERT INTO $pins_tbl (`pin`, `pin_creator`, `date_created`, `status`,`activation_date`) 
    VALUES ('$pin','$loggedin_user_id','$current_date','inactive','Not active') ");
}
$total_pin_cost = to_decimal($total_pin_cost);
$pin_text = ($pincount > 1) ? "pins":"pin";
mysqli_query($conn,"UPDATE $balance_tbl SET wallet = wallet - $total_pin_cost, expenditure = expenditure + $total_pin_cost WHERE user_id = '$loggedin_user_id' ");
mysqli_query($conn,"INSERT INTO $transaction_tbl (`user_id`, `amount`, `transaction_charge`, `net_amount`, `description`,`category`, `date`, `status`)
                         VALUES ('$loggedin_user_id','$total_pin_cost','0.00','$total_pin_cost','bought $pincount $pin_text ','pin','$current_date','debit') ");
mysqli_query($conn,"INSERT INTO $pin_history_tbl ( `pin_creator`, `pin_count`, `expenditue`, `date_created`) VALUES ('$loggedin_user_id','$pincount','$total_pin_cost','$current_date') ");
//
$user_income = income($loggedin_user_id);
$user_wallet = wallet($loggedin_user_id);
if ($user_income > $user_wallet) {
    mysqli_query($conn, "UPDATE $balance_tbl SET income = '$user_wallet' WHERE user_id = '$loggedin_user_id' ");
}
echo "Pin created successfully";
function random_strings($length_of_string)
{
  $str_result = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}
?>