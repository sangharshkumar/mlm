<?php

$level = 0;
function level($user_id)
{
    global $level;
    $left_right_id = get_left_right_id($user_id);
    check_level($left_right_id);
    $output_level = $level;
    $level = 0;
    return $output_level;
}


function check_level($left_right_id)
{
    global $level;
    if (in_array(0, $left_right_id)) {
        return $level;
    }
    $level += 1;
    $ids = array();
    foreach ($left_right_id as $id) {
        $new_ids = get_left_right_id($id);
        $ids = array_merge($new_ids, $ids);
    }
    check_level($ids);
}


######## SOME FUNCTIONS START########

// Get used id if user is logged in
if (is_loggedin()) {
    $loggedin_user_id = loggedin_user_id();
}

// Get loggedin user id
function loggedin_user_id()
{
    global $conn;
    global $login_session_tbl;
    if (!is_loggedin()) {
        return false;
        exit();
    }
    $session_id = clean_text($_COOKIE['session_id']);
    $query = mysqli_query($conn, "SELECT * FROM $login_session_tbl WHERE session_id = '$session_id' ");
    $data = mysqli_fetch_array($query);
    return $data['user_id'];
}

// Remove space & slashes and special symbols from string
function clean_text($string)
{
    $string = trim(addslashes(htmlentities(stripslashes(htmlspecialchars($string)))));
    return $string;
}

// Check if string is empty or not
function is_empty($string)
{
    $string = clean_text($string);
    if (($string != '') && ($string != "undefined") && ($string != null) && (!empty($string))) {
        return false;
    } else {
        return true;
    }
}

// Check if user is loggedin or not
function is_loggedin()
{
    global $conn;
    global $users_tbl;
    global $login_session_tbl;
    global $current_date;

    if (!isset($_COOKIE['session_id'])) {
        return false;
    } else {
        $session_id = clean_text($_COOKIE['session_id']);
        if (is_empty($session_id)) {
            return false;
        } else {
            $query = mysqli_query($conn, "SELECT * FROM $login_session_tbl WHERE session_id = '$session_id' ");
            if (!mysqli_num_rows($query)) {
                return false;
            } else {
                $data = mysqli_fetch_array($query);
                $valid_till = ($data['valid_till']);
                if ($valid_till < $current_date) {
                    return false;
                } else {
                    $user_id = $data['user_id'];
                    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id ='$user_id' ");
                    if (mysqli_num_rows($query)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}

// Convert data to date & time
function date_time($date)
{
    return ($date == '') ? '' : date("d F Y H:i:s", $date);
}

// Convert data to date
function to_date($date)
{
    return date("d F Y", $date);
}

// Create random number
function random_number($length)
{
    $key = '';
    $keys = array_merge(range(0, 9));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

// Convert data to ruppee form
function to_decimal($text)
{
    return number_format((float)$text, 2, '.', '');
}

// Get random strings
function get_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

// Generate a new session id
function new_session_id()
{
    return sprintf(
        '%04x%04x%04x%04x%04x%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}


// Compress image

function compressImage($source, $destination, $quality)
{
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    imagejpeg($image, $destination, $quality);
}

// Generate new toke
function new_token()
{
    $token = bin2hex(random_bytes(15));
    return $token;
}

// Convert data to date
function defaultdate($date)
{
    return date("d-m-Y H:i:s", $date);
}

// Check if token is valid
function is_member_token_valid($token)
{
    global $conn;
    global $tokens_tbl;
    global $current_date;

    $query = mysqli_query($conn, "SELECT * FROM $tokens_tbl WHERE token = '$token' AND token_status = '0' ");
    if (!mysqli_num_rows($query)) {
        return false;
        exit();
    }

    $data =  mysqli_fetch_array($query);
    $token_valid_date =  strtotime($data['token_valid_date']);

    if ($token_valid_date < $current_date) {
        return false;
        exit();
    } else {
        return true;
    }
}
function update_token($token)
{
    global $conn;
    global $tokens_tbl;
    mysqli_query($conn, "UPDATE $tokens_tbl SET token_status = '1' WHERE token ='$token' ");
}

// check f ticket is created by user
function is_my_ticket($ticket_id, $user_id)
{
    global $conn;
    global $tickets_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE ticket_id = '$ticket_id' AND ticket_creator = '$user_id' ");
    if (!mysqli_num_rows($query)) {
        return false;
    } else {
        return true;
    }
}

// Logout all users after changing password
function logout_all_user($user_id)
{
    global $conn;
    global $login_session_tbl;
    mysqli_query($conn, "DELETE FROM $login_session_tbl WHERE user_id = '$user_id' ");
}

// Logout all users except current user
function logout_with_excep($user_id)
{
    global $conn;
    global $login_session_tbl;
    $session_id = $_COOKIE['session_id'];
    mysqli_query($conn, "DELETE FROM $login_session_tbl WHERE user_id = '$user_id' AND session_id != '$session_id' ");
}

######## SOME FUNCTIONS END########








########## USERS TABLE DATA START #######

// Get user all data
function user_data($user_id)
{
    global $conn;
    global $users_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$user_id'");
    return mysqli_fetch_array($query);
}

// Check if user id is valid or not
function is_user_id($user_id)
{
    global $conn;
    global $users_tbl;

    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$user_id' ");
    if (mysqli_num_rows($query)) {
        return true;
    } else {
        return false;
    }
}

// Get user name
function user_name($user_id)
{
    $data = user_data($user_id);
    return $data['user_name'];
}

// Get user first name
function user_first_name($user_id)
{
    $data = user_data($user_id);
    return $data['first_name'];
}

// Get user last name
function user_last_name($user_id)
{
    $data = user_data($user_id);
    return $data['last_name'];
}

// Get user name
function user_fullname($user_id)
{
    $data = user_data($user_id);
    return $data['first_name'] . " " . $data['last_name'];
}

// Get user email
function user_email($user_id)
{
    $data = user_data($user_id);
    return $data['user_contact_email'];
}

// Get user image
function user_image($user_id)
{
    global $base_url;
    $data = user_data($user_id);
    $img = $data['user_image'];
    if ($img == 'avatar.jpg') {
        $img_url = $base_url . '/assets/images/web/' . $img;
    } else {
        $img_url = $base_url . '/assets/images/users/' . $img;
    }
    return $img_url;
}

// Get user phone
function user_phone($user_id)
{
    $data = user_data($user_id);
    return $data['user_phone'];
}

// Get user address
function user_address($user_id)
{
    $data = user_data($user_id);
    return $data['user_address'];
}

// Get user pincode
function user_pincode($user_id)
{
    $data = user_data($user_id);
    return $data['user_pincode'];
}

// Get user registration date
function user_registration_date($user_id)
{
    $data = user_data($user_id);
    return date_time($data['user_registration_date']);
}

// Get user account number
function user_account_number($user_id)
{
    $data = user_data($user_id);
    return $data['user_account_number'];
}

// Get user ifsc code
function user_upi($user_id)
{
    $data = user_data($user_id);
    return $data['user_upi'];
}

// Get user status 
function user_status($user_id)
{
    $data = user_data($user_id);
    return $data['status'];
}
########## USERS TABLE DATA END #######






############ USER TREE TABLE DATA START #############

// Get user tree all data
function user_tree_data($user_id)
{
    global $conn;
    global $tree_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tree_tbl WHERE user_id = '$user_id' ");
    return mysqli_fetch_array($query);
}

// Get user left count
function left_count($user_id)
{
    $data = user_tree_data($user_id);
    return $data['left_count'];
}

// Get user right count
function right_count($user_id)
{
    $data = user_tree_data($user_id);
    return $data['right_count'];
}

// Get user referral id
function referred_by($user_id)
{
    $data = user_tree_data($user_id);
    $output = ($data['referral_id'] == 0) ? "root" : $data['referral_id'];
    return $output;
}

// Get user placement id
function placement_id($user_id)
{
    $data = user_tree_data($user_id);
    return $data['placement_id'];
}

// Get user placement type
function placement_type($user_id)
{
    $data = user_tree_data($user_id);
    return $data['placement_type'];
}

// Get user pair count
function pair_count($user_id)
{
    $data = user_tree_data($user_id);
    return $data['pair_count'];
}

############ USER TREE TABLE DATA END ################








########### FUNCTIONS TO SHOW USER TREE START #######

// Get user left and right id
function get_left_right_id($user_id)
{
    $data = user_tree_data($user_id);
    $output = array();
    $output[] = $data['left_id'];
    $output[] = $data['right_id'];
    return $output;
}

// Check if user is in user team
function user_is_in_my_team($user_id, $tree_id)
{
    global $tree_output;
    $left_right_id = get_left_right_id($user_id);
    update_tree($left_right_id);
    if ($user_id == $tree_id) {
        return true;
        exit();
    }
    if (in_array($tree_id, $tree_output)) {
        return true;
    } else {
        return false;
    }
}

// Get tree data
$tree = array();
$tree_all_data = array();
function show_tree($user_id)
{
    global $tree;
    global $tree_all_data;
    $referral_id = $user_id;
    $tree[] = $user_id;
    $left_right_id = get_left_right_id($user_id);
    update_tree_data($user_id, $left_right_id);
    foreach ($tree as $id) {
        $user_id = $id;
        $pid = placement_id($user_id);
        $name = user_name($user_id);
        $email = user_email($user_id);
        $img = user_image($user_id);
        $level = level($user_id);
        $left_count = left_count($user_id);
        $right_count = right_count($user_id);
        $referred_by = referred_by($user_id);
        $p_t = placement_type($user_id);
        $p_t = ($p_t == "left") ? "0" : "1";

        $a = direct_all_referral_id($user_id);
        $direct_left_referral = $a['direct_left_count'];
        $direct_right_referral =  $a['direct_right_count'];

        $tree_all_data[] = array(
            'id' => $user_id,
            'pid' => $pid,
            'name' => $name,
            'title' => $user_id,
            'email' => $email,
            'img' => $img,
            'left_count' => $left_count,
            'right_count' => $right_count,
            'referred_by' => $referred_by,
            'level' => $level,
            'direct_left_referral' => $direct_left_referral,
            'direct_right_referral' => $direct_right_referral,
            'p_t' => $p_t
        );
    }
    $tree_p_t = array_column($tree_all_data, 'p_t');
    array_multisort($tree_p_t, SORT_ASC, $tree_all_data);

    echo json_encode($tree_all_data, JSON_PRETTY_PRINT);
}


// Update data to show tree
function update_tree_data($user_id, $left_right_id)
{
    global $tree;
    global $base_url;
    global $tree_count;
    global $tree_all_data;
    $tree_count = 0;

    foreach ($left_right_id as $id) {
        $tree_count = $tree_count + 1;
        if ($tree_count == 1) {
            $p_t = '0';
        } else {
            $p_t = '1';
        }

        if ($id != 0) {
            $tree[] = $id;
            $left_right_id = get_left_right_id($id);
            update_tree_data($id, $left_right_id);
        } else {
            $rand_id = rand(100000, 99999999);
            $tree_all_data[] = array(
                'id' => "$rand_id",
                'pid' => $user_id,
                'p_t' => $p_t,
                'name' => 'Join member',
                'title' => 'Click here',
                'img' => $base_url . '/assets/images/web/add-icon.png',
            );
        }
    }
}

// Get direct all referral id
$direct_left_count = 0;
$direct_right_count = 0;
function direct_all_referral_id($referral_id)
{
    global $conn;
    global $tree_tbl;
    global $direct_left_count;
    global $direct_right_count;
    $array = array();
    $query = mysqli_query($conn, "SELECT * FROM $tree_tbl WHERE referral_id = '$referral_id' ");
    while ($row = mysqli_fetch_array($query)) {
        $array[] = $row['user_id'];
    }
    show_direct_referral_id_output($referral_id, $array);
    $output = array(
        'direct_left_count' => $direct_left_count,
        'direct_right_count' => $direct_right_count
    );
    return $output;
}

// Show output of direct referral id
function show_direct_referral_id_output($referral_id, $data)
{
    global $direct_left_count;
    global $direct_right_count;


    if (is_array($data)) {
        $direct_left_count = 0;
        $direct_right_count = 0;
        if (empty($data)) {
        } else {
            foreach ($data as $id) {
                $data = user_tree_data($id);
                $placement_id = $data['placement_id'];
                if ($placement_id == $referral_id) {
                    $placement_type = $data['placement_type'];
                    if ($placement_type == 'left') {
                        $direct_left_count = $direct_left_count + 1;
                    } elseif ($placement_type == 'right') {
                        $direct_right_count = $direct_right_count + 1;
                    }
                } else {
                    show_direct_referral_id_output($referral_id, $id);
                }
            }
        }
    } else {
        $user_data = user_tree_data($data);
        $placement_id = $user_data['placement_id'];
        if ($placement_id == $referral_id) {
            $placement_type = $user_data['placement_type'];
            if ($placement_type == 'left') {
                $direct_left_count = $direct_left_count + 1;
            } elseif ($placement_type == 'right') {
                $direct_right_count = $direct_right_count + 1;
            }
        } else {
            show_direct_referral_id_output($referral_id, $placement_id);
        }
    }
}
########### FUNCTIONS TO SHOW USER TREE END #########











########### BALANCE TABLE DATA START ###########

// Get user balance table data
function user_balance_data($user_id)
{
    global $conn;
    global $balance_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $balance_tbl WHERE user_id = '$user_id' ");
    $data = mysqli_fetch_array($query);
    return $data;
}

// Get user wallet
function wallet($user_id)
{
    $data = user_balance_data($user_id);
    return $data['wallet'];
}

// Get user income
function income($user_id)
{
    $data = user_balance_data($user_id);
    return $data['income'];
}

// Get user total income
function total_income($user_id)
{
    $data = user_balance_data($user_id);
    return $data['total_income'];
}

// Get user total withdrawl
function total_withdrawl($user_id)
{
    $data = user_balance_data($user_id);
    return $data['total_withdrawl'];
}

// Get user expenditure
function expenditure($user_id)
{
    $data = user_balance_data($user_id);
    return $data['expenditure'];
}

// Get user pending
function pending($user_id)
{
    $data = user_balance_data($user_id);
    return $data['pending'];
}

// Get user last added money
function last_added_money($user_id)
{
    $data = user_balance_data($user_id);
    return $data['last_added_money'];
}

// Get user last withdrawl money
function last_withdrawl_money($user_id)
{
    $data = user_balance_data($user_id);
    return $data['last_withdrawl'];
}

// Show transaction history
function show_transaction_history($user_id)
{
    global $conn;
    global $transaction_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE user_id = '$user_id' ORDER BY transaction_id DESC ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $amount = $data['amount'];
        $transaction_charge = $data['transaction_charge'];
        $net_amount = $data['net_amount'];
        $date = date_time($data['date']);
        $description = $data['description'];
        $status = $data['status'];
        if ($status == "credit") {
            $status = '<span class="label label-success">' . $status . '</span>';
        } elseif ($status == "debit") {
            $status = '<span class="label label-danger">' . $status . '</span>';
        } elseif ($status == "pending") {
            $status = '<span class="label label-warning">' . $status . '</span>';
        } elseif ($status == "capping") {
            $status = '<span class="label bg-orange">' . $status . '</span>';
        } else {
            $status = '<span class="label bg-info">' . $status . '</span>';
        } ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $c_symbol . $amount; ?></td>
            <td><?php echo $c_symbol . $transaction_charge; ?></td>
            <td><?php echo $c_symbol . $net_amount; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
    <?php
    }
    get_withdraw_transaction($user_id);
}

function get_withdraw_transaction($user_id)
{
    global $conn;
    global $c_symbol;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE user_id = '$user_id' AND status = 'pending' ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $amount = $data['amount'];
        $transaction_charge = $data['charge'] + $data['other_charge'];
        $net_amount = $data['payable'];
        $status = $data['status'];
        $requested_date = date_time($data['requested_date']);
        $date = $requested_date;
        if ($status == "success") {
            $status = '<span class="label label-danger">debit</span>';
        } elseif ($status == "pending") {
            $status = '<span class="label label-warning">' . $status . '</span>';
        } else {
            $status = '<span class="label bg-info">' . $status . '</span>';
        } ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $c_symbol . $amount; ?></td>
            <td><?php echo $c_symbol . $transaction_charge; ?></td>
            <td><?php echo $c_symbol . $net_amount; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo 'withdraw'; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
    <?php
    }
}

########### BALANCE TABLE DATA END ###########










############## SUPPORT TABLE DATA START ###############

// Check if ticket is valid or not
function is_ticket($ticket_id)
{
    global $conn;
    global $tickets_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE ticket_id = '$ticket_id' ");
    if (mysqli_num_rows($query)) {
        return true;
    } else {
        return false;
    }
}

// Get ticket all data
function ticket_data($ticket_id)
{
    global $tickets_tbl;
    if (!is_ticket($ticket_id)) {
        exit();
    }
    global $conn;
    global $tickets_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE ticket_id = '$ticket_id' ");
    $data = mysqli_fetch_array($query);
    return $data;
}

// Get ticket subject
function ticket_subject($ticket_id)
{
    $data = ticket_data($ticket_id);
    return  $data['ticket_subject'];
}

// Get ticket subject
function ticket_status($ticket_id)
{
    $data = ticket_data($ticket_id);
    return $data['status'];
}

// Get ticket creator
function ticket_creator($ticket_id)
{
    $data = ticket_data($ticket_id);
    return $data['ticket_creator'];
}

// Get ticket added date
function ticket_added_date($ticket_id)
{
    $data = ticket_data($ticket_id);
    return date_time($data['ticket_create_date']);
}

// Get ticket last reply date
function last_reply_date($ticket_id)
{
    $data = ticket_data($ticket_id);
    return date_time($data['last_reply_date']);
}

// Get ticker close user
function ticket_closed_by($ticket_id)
{
    $data = ticket_data($ticket_id);
    return user_name($data['ticket_closed_by']);
}

// Get ticket message data
function ticket_message_data($id)
{
    global $ticket_messages_tbl;
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM $ticket_messages_tbl WHERE id = '$id' ");
    $data = mysqli_fetch_array($query);
    return $data;
}

// Get ticket message name
function ticket_message_name($id)
{
    $data = ticket_message_data($id);
    $user_id = $data['ticket_creator'];
    return user_name($user_id);
}

// Get ticket replied message
function ticket_replied_message($id)
{
    $data = ticket_message_data($id);
    return  $data['ticket_message'];
}

// Get ticket message files
function ticket_message_files($id)
{
    global $base_url;
    $data = ticket_message_data($id);
    $files = $data['ticket_files'];
    $files = explode(",", $files);
    $count = 0;
    $output = '';
    foreach ($files as $file) {
        if (!is_empty($file)) {
            $count = $count + 1;
            $output .= '<a class="link" href="' . $base_url . '/assets/images/users/' . $file . '">Attachment ' . $count . '</a><br>';
        }
    }
    return $output;
}

// Get ticket message date
function ticket_message_date($id)
{
    $data = ticket_message_data($id);
    $date =  $data['ticket_date'];
    return date_time($date);
}

// Show all tickets
function show_tickets($user_id)
{
    global $conn;
    global $tickets_tbl;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE ticket_creator = '$user_id' ORDER BY id DESC ");
    while ($data = mysqli_fetch_array($query)) {
        $ticket_id = $data['ticket_id'];
        $subject = ticket_subject($ticket_id);
        $status = ticket_status($ticket_id);
        $date = ticket_added_date($ticket_id); ?>
        <tr>
            <td><?php echo $subject; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $date; ?></td>
            <td><a style="line-height: 0;" href="<?php echo $base_url . '/support/ticket.php?ticket=' . $ticket_id ?>" style="color:#fff" class="btn btn-info btn-sm"><i style="font-size:20px;" class=" icon-arrow-right-circle "></i></a></td>
        </tr>
    <?php
    }
}

// Show all ticket messages
function show_tickets_messages($ticket_id)
{
    global $conn;
    global $tickets_tbl;
    global $ticket_messages_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE ticket_id = '$ticket_id' ");
    $data = mysqli_fetch_array($query);
    $ticket_id = $data['ticket_id'];
    $query = mysqli_query($conn, "SELECT * FROM $ticket_messages_tbl WHERE ticket_id = '$ticket_id' ORDER BY ID DESC ");
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $name = ticket_message_name($id);
        $message =  ticket_replied_message($id);
        $date = ticket_message_date($id); ?>
        <div class="col-12 single-note-item all-category py-1">
            <div class="card card-body">
                <span class="side-stick"></span>
                <h5 class="note-title text-truncate w-75 mb-0"><?php echo $name; ?></h5>
                <p class="note-date font-12 text-muted"><?php echo $date; ?></p>
                <div class="note-content">
                    <p class="note-inner-content text-muted"><?php echo $message; ?></p>
                </div>
                <div class="py-1">
                    <?php echo ticket_message_files($id); ?>
                </div>
            </div>
        </div>
    <?php
    }
}
############## SUPPORT TABLE DATA END ###############










################# PIN TABLE DATA START ##################

// Show user pin table data
function pin_tbl_data($user_id)
{
    global $conn;
    global $pins_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin_creator = '$user_id' ORDER BY status DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $pin = $row['pin'];
        $date = date_time($row['date_created']);
        $status = $row['status'];
        $activation_date = $row['activation_date'];
        if ($activation_date != 'Not active') {
            $activation_date = date_time($activation_date);
        } ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $pin; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $activation_date; ?></td>
        </tr>
    <?php
    }
}

// Get user total pins
function total_pins($user_id)
{
    global $conn;
    global $pins_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin_creator = '$user_id' ");
    return mysqli_num_rows($query);
}

// Get user active pins
function active_pins($user_id)
{
    global $conn;
    global $pins_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin_creator = '$user_id' AND status = 'active' ");
    return mysqli_num_rows($query);
}

// Get user inactive pins
function inactive_pins($user_id)
{
    global $conn;
    global $pins_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin_creator = '$user_id' AND status = 'inactive' ");
    return mysqli_num_rows($query);
}

// Check if code is a valid pin
function is_referral_code($referral_code)
{
    global $conn;
    global $pins_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin = '$referral_code' AND status = 'inactive' ");
    if (mysqli_num_rows($query)) {
        return true;
    } else {
        return false;
    }
}

################# PIN TABLE DATA END ##################










################# REGISTRATION DATA START ##################
// 

function add_balance_row($user_id)
{
    global $conn;
    global $balance_tbl;
    mysqli_query($conn, "INSERT INTO $balance_tbl (`user_id`, `wallet`, `income`, `total_income`, `total_withdrawl`, `expenditure`, `pending`, `last_added_money` , `total_added_money`, `last_withdrawl`)
    VALUES('$user_id','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00') ");
}
// Check placement type
function check_placement_type($placement_id, $placement_type)
{
    $data = user_tree_data($placement_id);
    $placement_type_id = $placement_type . "_id";
    $id = $data[$placement_type_id];
    if ($id != 0) {
        echo "Placement id $placement_id with $placement_type is already in use";
        exit();
    }
}

// Update referral user id balance and used pin for registration
function update_referral_code_and_balance($user_id, $referral_id, $referral_code)
{
    global $conn;
    global $current_date;
    global $pins_tbl;
    mysqli_query($conn, "UPDATE $pins_tbl SET status = 'active', activation_date = '$current_date' WHERE pin = '$referral_code' ");
    update_referral_income($referral_id,$user_id);
}

function update_referral_income($user_id,$agent_id){
    global $conn;
    global $referral_income_tbl;
    global $current_date;
    $referral_amt = '10.00';
    mysqli_query($conn,"INSERT INTO $referral_income_tbl (`user_id`, `amount`, `agent_id`, `date`) 
    VALUES ('$user_id','$referral_amt','$agent_id','$current_date') ");
    update_balance($user_id, $referral_amt, '1');
}

// Update user left or right id
function update_placement_data($placement_id, $placement_type, $user_id)
{
    global $conn;
    global $tree_tbl;
    $placement_type_id = $placement_type . "_id";
    mysqli_query($conn, "UPDATE $tree_tbl SET $placement_type_id = '$user_id' WHERE `user_id` = '$placement_id' ");
}

// Increse left and right count of users
function binary_count($referral_id, $placement_type)
{
    global $conn;
    global $tree_tbl;
    while ($referral_id != 0) {
        $placement_type_count = $placement_type . "_count";
        mysqli_query($conn, "UPDATE $tree_tbl SET $placement_type_count = $placement_type_count+1 WHERE user_id = '$referral_id' ");
        check_level_income($referral_id);
        is_pair_generated($referral_id, $placement_type_count);
        $placement_type = placement_type($referral_id);
        $referral_id = placement_id($referral_id);
    }
}

// Check if pair is generate or not
function is_pair_generated($referral_id, $placement_type_count)
{
    global $conn;
    global $tree_tbl;
    $com_pair = ($placement_type_count == "left_count") ? "right_count" : "left_count";
    $user_data = user_tree_data($referral_id);
    if (($user_data[$placement_type_count] <= $user_data[$com_pair]) && (($user_data['left_count'] !== 0) && ($user_data['right_count'] !== 0))) {
        mysqli_query($conn, "UPDATE $tree_tbl SET pair_count = pair_count + 1 WHERE user_id ='$referral_id' ");
        update_pair_count_tbl($referral_id);
    }
}


function update_pair_count_tbl($user_id)
{
    global $conn;
    global $pair_count_tbl;
    $date = strtotime(date("d-m-Y"));
    $query = mysqli_query($conn, "SELECT * FROM $pair_count_tbl WHERE user_id = '$user_id' AND date = '$date' ");
    if (mysqli_num_rows($query)) {
        mysqli_query($conn, "UPDATE $pair_count_tbl SET pair_count = pair_count + 1 WHERE user_id = '$user_id' AND date = '$date' ");
    } else {
        mysqli_query($conn, "INSERT INTO $pair_count_tbl (`user_id`,`date`,`pair_count`) VALUES ('$user_id','$date','1') ");
    }
}

function check_level_income($user_id)
{
    global $conn;
    global $level_income_tbl;
    global $current_date;
    $level = level($user_id);
    if ($level > 3) {
        return;
    }
    $amount = [0,20, 40, 100];
    for ($i = $level; $i > 0; $i--) {
        $query = mysqli_query($conn, "SELECT * FROM $level_income_tbl WHERE user_id = '$user_id' AND level = '$i' ");
        if (!mysqli_num_rows($query)) {
            $income = $amount[$i];
            mysqli_query($conn, "INSERT INTO $level_income_tbl ( `user_id`, `amount`, `level`, `date`) VALUES
            ('$user_id','$income','$i','$current_date') ");
            update_balance($user_id, $income, '2');
        }
    }
}


function update_balance($user_id, $income, $income_category)
{
    global $conn;
    global $balance_tbl;
    global $current_date;
    global $transaction_tbl;
    // Income Category 1 = Referral Income, 2 = Level Income
    $txn_description = '';
    if ($income_category == 1) {
        $txn_description = 'referral income';
    } elseif ($income_category == 2) {
        $txn_description = 'level income';
    }
    mysqli_query($conn, "UPDATE $balance_tbl SET wallet = wallet+$income, income = income+$income , total_income = total_income+$income WHERE user_id = '$user_id'  ");
    mysqli_query($conn, "INSERT INTO $transaction_tbl (`user_id`, `amount`, `transaction_charge`, `net_amount`, `description`,`category`, `date`, `status`)
       VALUES ('$user_id','$income','0','$income','$txn_description','','$current_date','credit') ");
}



################# REGISTRATION DATA END ##################








######### SHOW TOTAL TEAM START ######

// Show total team
$tree_output = array();
function show_total_team($user_id)
{
    global $tree_output;
    $tree_output[] = $user_id;
    $left_right_id = get_left_right_id($user_id);
    update_tree($left_right_id);
    $output = array();
    foreach ($tree_output as $id) {
        $name = user_name($id);
        $referred_by = referred_by($id);
        $level = level($id);
        $date = user_registration_date($id);
        $status = user_status($id);
        $output[] = array(
            'name' => $name,
            'id' => $id,
            'referred_by' => $referred_by,
            'level' => $level,
            'date' => $date,
            'status' => $status
        );
    }

    usort($output, 'date_compare');
    $output = array_reverse($output);
    get_my_team_output($output);
}

// Compare two dates
function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}

// Add data to output
function update_tree($left_right_id)
{
    global $tree_output;
    foreach ($left_right_id as $id) {
        if ($id != 0) {
            $tree_output[] = $id;
            $left_right_id = get_left_right_id($id);
            update_tree($left_right_id);
        }
    }
}

// Get total team output
function get_my_team_output($array)
{
    $count = 0;
    foreach ($array as $data) {
        $count = $count + 1;
        $name = $data['name'];
        $id = $data['id'];
        $referred_by = $data['referred_by'];
        $level = $data['level'];
        $date = $data['date'];
        $status = $data['status']; ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $id; ?></td>
            <td><?php echo $referred_by; ?></td>
            <td><?php echo $level; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
    <?php
    }
}
######### SHOW TOTAL TEAM END ######











####### INCOME HISTORY TABLE START ########

// Show income history table
function level_income_tbl($user_id)
{
    global $conn;
    global $level_income_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $level_income_tbl WHERE user_id = '$user_id' ORDER BY id DESC ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $amount = $data['amount'];
        $level = $data['level'];
        $date = date_time($data['date']);
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo  $c_symbol . $amount; ?></td>
            <td><?php echo $level; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}
function show_referral_income_history($user_id)
{
    global $conn;
    global $referral_income_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $referral_income_tbl WHERE user_id = '$user_id' ORDER BY id DESC ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $amount = $data['amount'];
        $date = date_time($data['date']);
        $agent_id = $data['agent_id'];
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo  $c_symbol . $amount; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $agent_id; ?></td>
        </tr>
    <?php
    }
}

####### INCOME HISTORY TABLE END ########











###### DASHBOARD DATA START #######

// Get user total downlines
function total_downlines($user_id)
{
    $left_count = left_count($user_id);
    $right_count = right_count($user_id);
    return $left_count + $right_count;
}

// Count user referral income
function level_income($user_id)
{
    global $conn;
    global $level_income_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $level_income_tbl WHERE user_id = '$user_id' ");
    $amount = '0.00';
    while ($row = mysqli_fetch_array($query)) {
        $amount = $amount + $row['amount'];
    }
    return $amount;
}
// Count user referral income
function referral_income($user_id)
{
    global $conn;
    global $referral_income_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $referral_income_tbl WHERE user_id = '$user_id' ");
    $amount = '0.00';
    while ($row = mysqli_fetch_array($query)) {
        $amount = $amount + $row['amount'];
    }
    return $amount;
}

// Count user direct referrals id
function direct_referral_count($user_id)
{
    global $conn;
    global $tree_tbl;
    $count = 0;
    $query = mysqli_query($conn, "SELECT * FROM $tree_tbl WHERE referral_id = '$user_id' ");
    while ($row = mysqli_fetch_array($query)) {
        $count++;
    }
    return $count;
}

###### DASHBOARD DATA END #######




#### My referral table data start ######


function show_my_referrals($user_id)
{
    global $conn;
    global $tree_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tree_tbl WHERE referral_id = '$user_id' ORDER BY id DESC ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $client_user_id = $data['user_id'];
        $name = user_name($client_user_id);
        $date = (user_registration_date($client_user_id));
        $status = 'active'; ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $client_user_id; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
    <?php
    }
}
#### My referral table data end ####


####### REWARD TABLE START ######
// Show reward table data
function show_reward_tbl($user_id)
{
    global $conn;
    global $rewards_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $rewards_tbl");
    $count = 1;
    while ($row = mysqli_fetch_array($query)) {
        $reward_id = $row['reward_id'];
        $matching_pair = $row['matching_pair'];
        $rewards = $row['reward'];
        $has_achieved = has_achieved_reward($user_id, $reward_id); ?>
        <tr>
            <th scope="row"><?php echo $count; ?></th>
            <td><?php echo $matching_pair; ?></td>
            <td><?php echo $c_symbol . $rewards; ?> </td>
            <td><?php echo $has_achieved; ?></td>
        </tr>
<?php
        $count++;
    }
}

// Get if user has achieved the reward
function has_achieved_reward($user_id, $reward_id)
{
    global $conn;
    global $users_rewards_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $users_rewards_tbl WHERE user_id = '$user_id' AND reward_id = '$reward_id' ");
    if (mysqli_num_rows($query)) {
        return "Achieved";
    } else {
        return "Not Achieved";
    }
}
####### REWARD TABLE END  ######


########## REGISTRATION OTP METHOD START ############
function new_otp($email)
{
    global $conn;
    global $otp_tbl;
    $otp = rand(11111, 99999);
    $query = mysqli_query($conn, "SELECT * FROM $otp_tbl WHERE otp_email = '$email' AND otp = '$otp' ");
    if (mysqli_num_rows($query)) {
        $otp = rand(22222, 91234);
    }
    return $otp;
}
function is_valid_otp($otp, $email)
{
    global $conn;
    global $otp_tbl;
    global $current_date;

    $query = mysqli_query($conn, "SELECT * FROM $otp_tbl WHERE otp = '$otp' AND otp_email = '$email' AND otp_status = '0' ");
    if (!mysqli_num_rows($query)) {
        return false;
        exit();
    }
    $data = mysqli_fetch_array($query);
    $otp_valid_date = ($data['otp_valid_date']);
    if ($otp_valid_date < $current_date) {
        return false;
    } else {
        return true;
    }
}
function update_otp($otp, $email)
{
    global $conn;
    global $otp_tbl;
    mysqli_query($conn, "UPDATE $otp_tbl SET otp_status = '1'  WHERE otp = '$otp' AND otp_email ='$email'");
}
########## REGISTRATION OTP METHOD END ############





function is_user_blocked($user_id)
{
    $data = user_data($user_id);
    $status = $data['status'];
    if ($status == "block") {
        return true;
    } else {
        return false;
    }
}


function update_data($input)
{
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if ($input_count != '0') {
        if ($input_count == '1') {
            return substr($input, 0, -4) . 'K';
        } elseif ($input_count == '2') {
            return substr($input, 0, -8) . 'M';
        } elseif ($input_count == '3') {
            return substr($input, 0, -12) . 'B';
        } else {
            return;
        }
    } else {
        return $input;
    }
}

//    function update_data($n)
//    {
//        // first strip any formatting;
//        $n = (0+str_replace(",", "", $n));
//        // is this a number?
//        if (!is_numeric($n)) {
//            return false;
//        }
//        // now filter it;
//        if ($n > 1000000000000) {
//            return round(($n/1000000000000), 2).'T';
//        } elseif ($n > 1000000000) {
//            return round(($n/1000000000), 2).'B';
//        } elseif ($n > 1000000) {
//            return round(($n/1000000), 2).'M';
//        } elseif ($n > 1000) {
//            return round(($n/1000), 2).'K';
//        }

//        return number_format($n);
//    }


function user_account_image($user_id)
{
    global $base_url;
    $data = user_data($user_id);
    $src =  $data['account_image'];
    return $base_url . '/assets/images/users/' . $src;
}

function level_number($user_id, $referral_id)
{
    if ($referral_id == $user_id) {
        return 0;
    }
    $placement_id = placement_id($user_id);
    if ($placement_id == $referral_id) {
        return '1';
    }
    $count = 1;
    while ($placement_id != $referral_id) {
        $count += 1;
        $user_id = $placement_id;
        $placement_id = placement_id($placement_id);
        if ($placement_id == $referral_id) {
            return $count;
        }
    }
}





function br()
{
    echo '<br>';
}
