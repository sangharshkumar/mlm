<?php

// Check if user is loggedin or not
function is_admin_loggedin()
{
    global $conn;
    global $admin_id;
    global $login_session_tbl;
    global $current_date;

    if (!isset($_COOKIE['admin_session_id'])) {
        return false;
    } else {
        $session_id = clean_text($_COOKIE['admin_session_id']);
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
                    if ($user_id === $admin_id) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}

function total_team($action)
{
    global $conn;
    global $base_url;
    global $users_tbl;
    global $admin_id;

    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' ORDER BY user_registration_date DESC");
    if ($action == "block") {
        $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' AND  status = 'block' ORDER BY user_registration_date DESC");
    }
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $user_id = $data['user_id'];
        $user_name = user_name($user_id);
        $email = user_email($user_id);
        $level = level($user_id);
        $referral_id = referred_by($user_id);
        $date = user_registration_date($user_id);
        $status = user_status($user_id);
        if ($status == 'active') {
            $label = 'success';
        } else {
            $label = 'danger';
        }
        $blocked_date = blocked_date($user_id);
?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $level; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $referral_id . '/profile/'; ?>"><?php echo $referral_id; ?></a></td>
            <td><?php echo $date; ?></td>
            <?php
            if ($action == "block") {
            ?>
                <td><?php echo $blocked_date; ?></td>
            <?php
            }
            ?>
            <td><span class="label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"></button>
                    <div class="shadow dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" target="_blank" href="<?php echo $base_url; ?>/admin/genealogy/tree/<?php echo $user_id; ?>"><i class="cs-icon mdi mdi-file-tree"></i>Tree View</a>
                        <a class="dropdown-item" target="_blank" href="<?php echo $base_url; ?>/admin/genealogy/total-team/<?php echo $user_id; ?>"><i data-feather="users" class="cs-icon feather-icon"></i>Downline List</a>
                        <a class="dropdown-item" target="_blank" href="<?php echo $base_url; ?>/admin/user/<?php echo $user_id; ?>/profile"><i class="cs-icon ti-pencil-alt"></i>View User</a>
                        <a class="dropdown-item" target="_blank" href="<?php echo $base_url; ?>/admin/cs/login.php?user=<?php echo $user_id; ?>"><i data-feather="log-in" class="cs-icon feather-icon"></i>Login As Client</a>
                        <a class="dropdown-item" target="_blank" id="block_user" data-id="<?php echo $user_id ?>"><i data-feather="lock" class="cs-icon feather-icon"></i>Block</a>
                        <a class="dropdown-item" target="_blank" id="unblock_user" data-id="<?php echo $user_id ?>"><i data-feather="unlock" class="cs-icon feather-icon"></i>Unblock</a>
                    </div>
                </div>
            </td>
        </tr>
    <?php
    }
}






// Get tree data
$admin_tree = array();
$admin_tree_all_data = array();
function show_admin_tree($admin_id)
{
    global $tree;
    global $tree_all_data;
    $tree[] = $admin_id;
    $left_right_id = get_left_right_id($admin_id);
    update_admin_tree_data($left_right_id);
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
            'level' => $level,
            'left_count' => $left_count,
            'right_count' => $right_count,
            'referred_by' => $referred_by,
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
function update_admin_tree_data($left_right_id)
{
    global $tree;
    global $tree_count;
    $tree_count = 0;

    foreach ($left_right_id as $id) {
        if ($id != 0) {
            $tree[] = $id;
            $left_right_id = get_left_right_id($id);
            update_admin_tree_data($left_right_id);
        }
    }
}




function supports_list($option)
{
    global $base_url;
    global $conn;
    global $tickets_tbl;


    if ($option == "pending") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'pending' ORDER BY ticket_create_date DESC ");
    } elseif ($option == "open") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'open' ORDER BY ticket_create_date DESC ");
    } elseif ($option == "closed") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'closed' ORDER BY ticket_create_date DESC ");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl ORDER BY ticket_create_date DESC");
    }

    if (!mysqli_num_rows($query)) {
        echo '<tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No data available in table</td></tr>';
    }
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $ticket_id = $row['ticket_id'];
        $subject = ticket_subject($ticket_id);
        $user_id = ticket_creator($ticket_id);
        $user_name = user_name($user_id);
        $status = ticket_status($ticket_id);
        $ticket_added_date = ticket_added_date($ticket_id);
        $last_reply_date = last_reply_date($ticket_id);
        if ($status == 'open') {
            $label = 'success';
        }
        if ($status == 'closed') {
            $label = 'danger';
        }
        if ($status == 'pending') {
            $label = 'warning';
        } ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $subject; ?></td>
            <td><?php echo $user_name; ?></td>
            <td><?php echo $user_id; ?></td>
            <td><?php echo $ticket_added_date; ?></td>
            <td><?php echo $last_reply_date; ?></td>
            <td><span class="label label-<?php echo $label; ?>"><?php echo $status; ?></span></td>
            <td><a style="line-height: 0;" href="<?php echo $base_url . '/admin/support/ticket.php?ticket=' . $ticket_id ?>" style="color:#fff" class="btn btn-info btn-sm"><i style="font-size:20px;" class=" icon-arrow-right-circle "></i></a></td>
        </tr>
    <?php
    }
}


function pin_table($from_date, $to_date)
{
    global $conn;
    global $pins_tbl;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE ( date_created BETWEEN '$from_date' AND '$to_date' ) ORDER BY date_created DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $user_id = $row['pin_creator'];
        $user_name = user_name($user_id);
        $pin = $row['pin'];
        $date_created = date_time($row['date_created']);
        $activation_date = $row['activation_date'];
        $activation_date = ($activation_date !== 'Not active') ? date_time($activation_date) : $activation_date;
        $status = $row['status'];
        if ($status == 'active') {
            $label = 'success';
        } else {
            $label = 'info';
        } ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><?php echo $pin; ?></td>
            <td><?php echo $date_created; ?></td>
            <td><?php echo $activation_date; ?></td>
            <td><span class="label label-<?php echo $label ?>"><?php echo $status; ?></span> </td>
        </tr>
    <?php
    }
}

function custom_total_pins($from_date, $to_date)
{
    global $conn;
    global $his;
    global $pins_tbl;
    if ($from_date == $to_date) {
        $from_date = date("d-m-Y", $from_date);
        $from_date = strtotime($from_date);
        $to_date = date("d-m-Y", $to_date);
        $to_date = $to_date . $his;
        $to_date = strtotime($to_date);
    }

    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE date_created BETWEEN '$from_date' AND '$to_date' ");
    $total_pins = 0;
    while ($row = mysqli_fetch_array($query)) {
        $total_pins = $total_pins + 1;
    }
    return $total_pins;
}

function custom_active_pins($from_date, $to_date)
{
    global $conn;
    global $pins_tbl;
    global $his;
    if ($from_date == $to_date) {
        $from_date = date("d-m-Y", $from_date);
        $from_date = strtotime($from_date);
        $to_date = date("d-m-Y", $to_date);
        $to_date = $to_date . $his;
        $to_date = strtotime($to_date);
    }
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE status = 'active' AND activation_date BETWEEN '$from_date' AND '$to_date'  ");
    $active_pins = 0;
    while ($row = mysqli_fetch_array($query)) {
        $active_pins = $active_pins + 1;
    }
    return $active_pins;
}

function custom_inactive_pins($from_date, $to_date)
{

    global $conn;
    global $pins_tbl;
    global $his;
    if ($from_date == $to_date) {
        $from_date = date("d-m-Y", $from_date);
        $from_date = strtotime($from_date);
        $to_date = date("d-m-Y", $to_date);
        $to_date = $to_date . $his;
        $to_date = strtotime($to_date);
    }
    $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE status = 'inactive' AND date_created BETWEEN '$from_date' AND '$to_date' ");
    $inactive_pins = 0;
    while ($row = mysqli_fetch_array($query)) {
        $inactive_pins = $inactive_pins + 1;
    }
    return $inactive_pins;
}


function dashboard_graph($from_date, $to_date)
{
    global $conn;
    global $admin_id;
    global $users_tbl;
    global $his;
    $from_date = defaultdate($from_date);
    $to_date = defaultdate($to_date);
    $s_from_date = new Datetime($from_date);
    $s_to_date = new Datetime($to_date);

    $registration_count = '';
    $time_range = '';
    for ($i = $s_from_date; $i <= $s_to_date; $i->modify('+1 day')) {
        $s_date = $i->format("d-m-Y");

        $time_range .= ($time_range == '') ? '"' . $s_date . '"' : ',"' . $s_date . '"';

        $from_s_date = $s_date . " 00:00:00";
        $to_s_date = $s_date . $his;
        $from_s_date = strtotime($from_s_date);
        $to_s_date = strtotime($to_s_date);
        $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' AND  user_registration_date BETWEEN '$from_s_date' AND '$to_s_date' ");
        if (mysqli_num_rows($query)) {
            $count = 0;
            while ($row = mysqli_fetch_array($query)) {
                $count = $count + 1;
            }
            $registration_count .=  ($registration_count == '') ? $count : ',' . $count;
        } else {
            $registration_count .=  ($registration_count == '') ? '0' : ',0';
        }
    }

    $output = array(
        'registration_count' => $registration_count,
        'time_range' => $time_range
    );
    return $output;
}




function pin_graph($from_date, $to_date)
{
    global $conn;
    global $pins_tbl;
    global $his;
    $from_date = defaultdate($from_date);
    $to_date = defaultdate($to_date);
    $s_from_date = new Datetime($from_date);
    $s_to_date = new Datetime($to_date);

    $active_pins_count = '';
    $sold_pins_count = '';
    $time_range = '';
    for ($i = $s_from_date; $i <= $s_to_date; $i->modify('+1 day')) {
        $s_date = $i->format("d-m-Y");
        $time_range .= ($time_range == '') ? '"' . $s_date . '"' : ',"' . $s_date . '"';
        $from_s_date = $s_date . " 00:00:00";
        $to_s_date = $s_date . $his;
        $from_s_date = strtotime($from_s_date);
        $to_s_date = strtotime($to_s_date);
        $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE date_created BETWEEN '$from_s_date' AND '$to_s_date' ");
        if (mysqli_num_rows($query)) {
            $count = 0;
            while ($row = mysqli_fetch_array($query)) {
                $count = $count + 1;
            }
            $sold_pins_count .=  ($sold_pins_count == '') ? $count : ',' . $count;
        } else {
            $sold_pins_count .=  ($sold_pins_count == '') ? '0' : ',0';
        }

        $query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE status = 'active' AND activation_date BETWEEN '$from_s_date' AND '$to_s_date' ");
        if (mysqli_num_rows($query)) {
            $count = 0;
            while ($row = mysqli_fetch_array($query)) {
                $count = $count + 1;
            }
            $active_pins_count .=  ($active_pins_count == '') ? $count : ',' . $count;
        } else {
            $active_pins_count .=  ($active_pins_count == '') ? '0' : ',0';
        }
    }

    $output = array(
        'active_pins_count' => $active_pins_count,
        'sold_pins_count' => $sold_pins_count,
        'time_range' => $time_range
    );
    return $output;
}


function total_tickets($action)
{
    global $conn;
    global $tickets_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl  ");
    if ($action == "today") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'pending' ");
    }
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
    }
    return $count;
}

function pending_tickets($action)
{
    global $conn;
    global $tickets_tbl;
    global $his;
    $from_date = date("d-m-Y") . " 00:00:00";
    $to_date = date("d-m-Y") . $his;
    $from_date = strtotime($from_date);
    $to_date = strtotime($to_date);
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'pending' AND ticket_create_date BETWEEN '$from_date' AND '$to_date' ");
    if ($action == "all") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl  WHERE status = 'pending' ");
    }

    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
    }
    return $count;
}

function open_tickets($action)
{
    global $conn;
    global $tickets_tbl;
    global $his;
    $from_date = date("d-m-Y") . " 00:00:00";
    $to_date = date("d-m-Y") . $his;
    $from_date = strtotime($from_date);
    $to_date = strtotime($to_date);
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'open' AND ticket_create_date BETWEEN '$from_date' AND '$to_date' ");
    if ($action == "all") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'open' ");
    }
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
    }
    return $count;
}

function closed_tickets($action)
{
    global $conn;
    global $tickets_tbl;
    global $his;
    $from_date = date("d-m-Y") . " 00:00:00";
    $to_date = date("d-m-Y") . $his;
    $from_date = strtotime($from_date);
    $to_date = strtotime($to_date);
    $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'closed' AND ticket_close_date BETWEEN  '$from_date'  AND '$to_date' ");
    if ($action == "all") {
        $query = mysqli_query($conn, "SELECT * FROM $tickets_tbl WHERE status = 'closed' ");
    }

    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
    }
    return $count;
}



function wallet_history_tbl()
{
    global $conn;
    global $base_url;
    global $balance_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $balance_tbl WHERE total_withdrawl > 0 ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $wallet = $c_symbol . $row['wallet'];
        $last_payout = $c_symbol . $row['last_withdrawl'];
        $total_payout = $c_symbol . $row['total_withdrawl']; ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $wallet; ?></td>
            <td><?php echo $last_payout; ?></td>
            <td><?php echo $total_payout; ?></td>
            <td><a style="line-height: 0;" href="#" style="color:#fff" class="btn btn-info btn-sm"><i style="font-size:20px;" class=" icon-arrow-right-circle "></i></a></td>
        </tr>
    <?php
    }
}

function payout_tbl()
{
    global $conn;
    global $base_url;
    global $withdraw_request_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'pending' ORDER BY requested_date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $withdraw_id = $row['withdraw_id'];
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $charge = $c_symbol . $row['charge'];
        $payable = $c_symbol . $row['payable'];
        $date = date_time($row['requested_date']); ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $charge; ?></td>
            <td><?php echo $payable; ?></td>
            <td><?php echo $date; ?></td>
            <td><a style="line-height: 0;" href="<?php echo $base_url . '/admin/wallet/withdraw?withdraw_id=' . $withdraw_id ?>" style="color:#fff" class="btn btn-info btn-sm"><i style="font-size:20px;" class=" icon-arrow-right-circle "></i></a></td>
        </tr>
    <?php
    }
}

function transfered_fund_tbl()
{
    global $conn;
    global $base_url;
    global $withdraw_request_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'success' ORDER BY payment_date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $withdraw_id = $row['withdraw_id'];
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $charge = $c_symbol . to_decimal($row['charge'] + $row['other_charge']);
        $payable = $c_symbol . $row['payable'];
        $requested_date = date_time($row['requested_date']);
        $payment_date = date_time($row['payment_date']);
        $payment_action = explode("||", $row['payment_method']);
        $payment_method = $payment_action[0];
        $payment_by = $payment_action[1];
        if ($payment_method == "qr") {
            $payment_by = 'QR Code';
        }
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $charge; ?></td>
            <td><?php echo $payable; ?></td>
            <td><?php echo $requested_date; ?></td>
            <td><?php echo $payment_date; ?></td>
            <td><?php echo $payment_by; ?></td>
            <td><a style="line-height: 0;" href="<?php echo $base_url . '/admin/wallet/withdraw?withdraw_id=' . $withdraw_id ?>" style="color:#fff" class="btn btn-info btn-sm"><i style="font-size:20px;" class=" icon-arrow-right-circle "></i></a></td>
        </tr>
    <?php
    }
}

function income_graph($from_date, $to_date)
{
    global $conn;
    global $transaction_tbl;
    global $his;
    $from_date = defaultdate($from_date);
    $to_date = defaultdate($to_date);
    $s_from_date = new Datetime($from_date);
    $s_to_date = new Datetime($to_date);
    // Graph
    $pin_graph = '';
    $payout_graph = '';
    $profit_graph = '';
    $wallet_graph = '';
    $time_range = '';

    for ($i = $s_from_date; $i <= $s_to_date; $i->modify('+1 day')) {
        // Amount
        $pin_amt = 0;
        $pay_amt = 0;
        $dep_amt = 0;
        $income = 0;

        $s_date = $i->format("d-m-Y");
        $time_range .= ($time_range == '') ? '"' . $s_date . '"' : ',"' . $s_date . '"';
        $from_date = strtotime($s_date);
        $to_date = strtotime($s_date . $his);
        $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE date BETWEEN '$from_date' AND '$to_date'");
        if (mysqli_num_rows($query)) {
            while ($row = mysqli_fetch_array($query)) {
                $payable_amt = $row['net_amount'];
                $category = $row['category'];
                if ($category == "pin") {
                    $pin_amt += $payable_amt;
                } elseif ($category == "deposit") {
                    $dep_amt += $payable_amt;
                } elseif ($category == "withdraw") {
                    $pay_amt += $payable_amt;
                }
            }
            $income = $dep_amt - $pay_amt;
        }
        $pin_graph .= ($pin_graph == '') ? $pin_amt : ',' . $pin_amt;
        $payout_graph .= ($payout_graph == '') ? $pay_amt : ',' . $pay_amt;
        $profit_graph .= ($profit_graph == '') ? $income : ',' . $income;

        $wallet = 0;
        $credit = 0;
        $debit = 0;
        $qry = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE date <= '$to_date' ");
        if (mysqli_num_rows($qry)) {
            while ($data = mysqli_fetch_array($qry)) {
                $wallet = 0;
                $category = $data['category'];
                $payable_amt =  $data['net_amount'];
                $payable_amt = ($category == "withdraw") ? $data['amount'] : $data['net_amount'];
                $status = $data['status'];
                if ($status == "credit") {
                    $credit += $payable_amt;
                } elseif ($status == "debit") {
                    $debit += $payable_amt;
                } elseif ($status == "credit & capping") {
                    $credit += $payable_amt;
                }
            }
            $wallet = $wallet + $credit - $debit;
        }
        $wallet_graph .= ($wallet_graph == '') ? $wallet : ',' . $wallet;
    }

    $output = array(
        'pin_graph' => $pin_graph,
        'payout_graph' => $payout_graph,
        'profit_graph' => $profit_graph,
        'time_range' => $time_range,
        'wallet_graph' => $wallet_graph
    );

    return $output;
}

function income_graph_tbl()
{
    global $conn;
    global $transaction_tbl;
    global $c_symbol;
    global $his;
    global $current_date;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl ORDER BY transaction_id ASC LIMIT 1");
    $data = mysqli_fetch_array($query);
    $date = $data['date'];
    $from_date = strtotime(date("d-m-Y", $date));
    $to_date = $current_date;

    $from_date = defaultdate($from_date);
    $to_date = defaultdate($to_date);
    $s_from_date = new Datetime($from_date);
    $s_to_date = new Datetime($to_date);

    $count = 0;
    for ($i = $s_from_date; $i <= $s_to_date; $i->modify('+1 day')) {
        $pin_earning = 0;
        $credit = 0;
        $debit = 0;
        $count += 1;
        $s_date = $i->format("d-m-Y");
        $from_s_date = $s_date . " 00:00:00";
        $to_s_date = $s_date . $his;
        $from_s_date = strtotime($from_s_date);
        $to_s_date = strtotime($to_s_date);
        $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE date BETWEEN '$from_s_date' AND '$to_s_date' ");
        if (mysqli_num_rows($query)) {
            while ($row = mysqli_fetch_array($query)) {
                $payable = $row['net_amount'];
                $category = $row['category'];
                if ($category == "withdraw") {
                    $debit += $payable;
                } elseif ($category == "pin") {
                    $pin_earning += $payable;
                } elseif ($category == "deposit") {
                    $credit += $payable;
                }
                $income = $credit - $debit;
            }
        }else{
            $income = 0;
        }
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $c_symbol . $credit; ?></td>
            <td><?php echo $c_symbol . $debit; ?></td>
            <td><?php echo $c_symbol . $income; ?></td>
            <td><?php echo $c_symbol . $pin_earning; ?></td>
            <td><?php echo $c_symbol . $pin_earning; ?></td>
            <td><?php echo to_date($from_s_date); ?></td>
        </tr>
    <?php
    }
}



function joining_graph($from_date, $to_date)
{
    global $conn;
    global $users_tbl;
    global $admin_id;
    global $his;
    $from_date = defaultdate($from_date);
    $to_date = defaultdate($to_date);
    $s_from_date = new Datetime($from_date);
    $s_to_date = new Datetime($to_date);
    $left_count_graph = '';
    $right_count_graph = '';
    $time_range = '';
    for ($i = $s_from_date; $i <= $s_to_date; $i->modify('+1 day')) {
        $s_date = $i->format("d-m-Y");
        $from_s_date = $s_date . " 00:00:00";
        $to_s_date = $s_date . $his;
        $from_s_date = strtotime($from_s_date);
        $to_s_date = strtotime($to_s_date);
        $time_range .= ($time_range == '') ? '"' . $s_date . '"' : ',"' . $s_date . '"';
        $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' AND user_registration_date BETWEEN '$from_s_date' AND '$to_s_date' ");
        if (mysqli_num_rows($query)) {
            $left_count = 0;
            $right_count = 0;
            while ($row = mysqli_fetch_array($query)) {
                $user_id = $row['user_id'];
                $placement_type = check_placement_type_by_admin($user_id);
                if ($placement_type == "left") {
                    $left_count += 1;
                } else if ($placement_type == "right") {
                    $right_count += 1;
                }
            }
            $left_count_graph .= ($left_count_graph == '') ? $left_count : ',' . $left_count;
            $right_count_graph .= ($right_count_graph == '') ? $right_count : ',' . $right_count;
        } else {
            $left_count_graph .= ($left_count_graph == '') ? '0' : ',0';
            $right_count_graph .= ($right_count_graph == '') ? '0' : ',0';
        }
    }

    $output = array(
        'left_count_graph' => $left_count_graph,
        'right_count_graph' => $right_count_graph,
        'time_range' => $time_range
    );

    return $output;
}



function joining_user_tbl()
{
    global $conn;
    global $users_tbl;
    global $admin_id;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' ORDER BY user_registration_date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $referral_id = referred_by($user_id);
        $placement_type = check_placement_type_by_admin($user_id);
        $date = user_registration_date($user_id); ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $referral_id . '/profile/'; ?>"><?php echo $referral_id; ?></a></td>
            <td><?php echo $placement_type; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}


function check_placement_type_by_admin($user_id)
{
    global $admin_id;
    if ($user_id == $admin_id) {
        return "root";
    }
    $placement_id = placement_id($user_id);
    if ($placement_id == $admin_id) {
        $placement_type = placement_type($user_id);
        return $placement_type;
    }

    while ($placement_id != $admin_id) {
        $user_id = $placement_id;
        $placement_id = placement_id($placement_id);
        if ($placement_id == $admin_id) {
            $placement_type = placement_type($user_id);
            return $placement_type;
        }
    }
}

function show_total_income($action)
{
    global $conn;
    global $transaction_tbl;
    global $c_symbol;
    $credit = 0;
    $debit = 0;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl");
    while ($row = mysqli_fetch_assoc($query)) {
        $category = $row['category'];
        if ($category == "withdraw") {
            $debit += $row['net_amount'];
        } else if ($category == "deposit") {
            $credit += $row['net_amount'];
        }
    }
    $output =  $credit - $debit;

    if (empty($action)) {
        $output = update_data($output);
    } else {
        $output = to_decimal($output);
    }
    return $c_symbol . $output;
}


function pins_earning($action)
{
    global $conn;
    global $c_symbol;
    global $transaction_tbl;
    $payout = 0;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE category = 'pin' ");
    while ($row = mysqli_fetch_assoc($query)) {
        $payout += $row['net_amount'];
    }
    if (empty($action)) {
        $payout = update_data($payout);
    } else {
        $payout = to_decimal($payout);
    }
    return $c_symbol . $payout;
}


function payout($action)
{
    global $conn;
    global $c_symbol;
    global $transaction_tbl;
    $payout = 0;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE category = 'withdraw' ");
    while ($row = mysqli_fetch_assoc($query)) {
        $payout += $row['net_amount'];
    }
    if (empty($action)) {
        $payout = update_data($payout);
    } else {
        $payout = to_decimal($payout);
    }
    return $c_symbol . $payout;
}


function today_income($action)
{
    global $conn;
    global $transaction_tbl;
    global $c_symbol;
    global $his;

    $date = strtotime(date("d-m-Y"));
    $to_date = strtotime(date("d-m-Y" . $his));

    $credit = 0;
    $debit = 0;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE date BETWEEN '$date' AND '$to_date'");
    while ($row = mysqli_fetch_assoc($query)) {
        $category = $row['category'];
        if ($category == "withdraw") {
            $debit += $row['net_amount'];
        } else if ($category == "deposit") {
            $credit += $row['net_amount'];
        }
    }
    $output =  $credit - $debit;

    if (empty($action)) {
        $output = update_data($output);
    } else {
        $output = to_decimal($output);
    }
    return $c_symbol . $output;
}




function total_count($user_id)
{
    $left_count = left_count($user_id);
    $right_count = right_count($user_id);
    return $left_count + $right_count;
}


function today_count($user_id)
{
    global $conn;
    global $users_tbl;
    global $admin_id;
    global $his;
    $date = date("d-m-Y");
    $from_date = $date . " 00:00:00";
    $to_date = $date . $his;
    $from_date = strtotime($from_date);
    $to_date = strtotime($to_date);
    $today_count = 0;
    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' AND  user_registration_date BETWEEN  '$from_date' AND '$to_date' ");
    while ($row = mysqli_fetch_array($query)) {
        $today_count += 1;
    }
    return $today_count;
}






// ######### WITHDRAW FUNCTIONS START #######
function is_withdraw_id($withdraw_id)
{
    global $conn;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
    if (mysqli_num_rows($query)) {
        return true;
    } else {
        return false;
    }
}

function get_withdraw_status($withdraw_id)
{
    global $conn;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
    $data = mysqli_fetch_array($query);
    return $data['status'];
}

function withdraw_payment_img($withdraw_id)
{
    global $conn;
    global $base_url;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
    $data = mysqli_fetch_array($query);
    $payment_method =  explode("||", $data['payment_method']);
    $payment_by = $payment_method[0];
    if ($payment_by == "qr") {
        $img = $payment_method[1];
    } else {
        $img = '';
    }
    return $base_url . '/assets/images/users/' . $img;
}

function withdraw_payable_amount($withdraw_id)
{
    global $conn;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
    $data = mysqli_fetch_array($query);
    return $data['payable'];
}

function user_withdraw_summary($user_id)
{
    global $conn;
    global $withdraw_request_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE user_id = '$user_id' AND status = 'success' ORDER BY requested_date DESC");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $charge = $row['charge'];
        $other_charge = $row['other_charge'];
        $charge = $c_symbol . ($charge + $other_charge);
        $payable = $c_symbol . $row['payable'];
        $requested_date = date_time($row['requested_date']);
        $payment_date = date_time($row['payment_date']);
        $payment_action = explode("||", $row['payment_method']);
        $payment_method = $payment_action[0];
        $payment_by = $payment_action[1];
        if ($payment_method == "qr") {
            $payment_by = 'QR Code';
        }
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $charge; ?></td>
            <td><?php echo $payable; ?></td>
            <td><?php echo $requested_date; ?></td>
            <td><?php echo $payment_date; ?></td>
            <td><?php echo $payment_by; ?></td>
        </tr>
    <?php
    }
}
// ######### WITHDRAW FUNCTIONS END #######




// ############## USERS DETAILS TABLE START #########
function user_deposit_summary($user_id)
{
    global $conn;
    global $deposit_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $deposit_tbl WHERE user_id = '$user_id' ORDER BY date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $date = date_time($row['date']);
        $payment_method = $row['payment_method'];
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $payment_method; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}


function level_income_tbl_profile($user_id)
{
    global $conn;
    global $level_income_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $level_income_tbl WHERE user_id = '$user_id' ORDER BY date DESC");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $date = date_time($row['date']);
        $level= $row['level'];
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $level; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}


function referral_income_tbl($user_id)
{
    global $conn;
    global $referral_income_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $referral_income_tbl WHERE user_id = '$user_id'  ORDER BY id DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_name = user_name($user_id);
        $agent_id = $row['agent_id'];
        $agent_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $date = date_time($row['date']);
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $agent_id . '/profile/'; ?>"><?php echo $agent_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $agent_id . '/profile/'; ?>"><?php echo $agent_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}

function pair_summary_tbl($user_id)
{
    global $conn;
    global $pair_count_tbl;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $pair_count_tbl WHERE user_id = '$user_id' ORDER BY date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_id = $row['user_id'];
        $user_name = user_name($user_id);
        $pair_count = $row['pair_count'];
        $date = to_date($row['date']);
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $pair_count; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}

function pair_income_tbl($user_id)
{
    global $conn;
    global $income_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $income_tbl WHERE user_id = '$user_id' AND category = '1'  ORDER BY date DESC ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_name = user_name($user_id);
        $amount = $c_symbol . $row['amount'];
        $date = date_time($row['date']);
        $status = $row['description']; ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
    <?php
    }
}

function pin_expenditure_tbl($user_id)
{
    global $conn;
    global $pins_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT DISTINCT date_created FROM $pins_tbl WHERE pin_creator = '$user_id' ORDER BY date_created DESC");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
        $user_name = user_name($user_id);
        $date = $row['date_created'];
        $pin_count = 0;
        $qry = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE date_created = '$date' AND pin_creator = '$user_id' ");
        while ($data = mysqli_fetch_array($qry)) {
            $pin_count += 1;
        }
        $amount = $c_symbol . to_decimal($pin_count * 49);
    ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $pin_count; ?></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo date_time($date); ?></td>
        </tr>

    <?php
    }
}


function total_transactions($user_id)
{
    global $conn;
    global $transaction_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE user_id = '$user_id' ");
    return mysqli_num_rows($query);
}

function total_deposit($user_id)
{
    global $conn;
    global $balance_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $balance_tbl WHERE user_id = '$user_id' ");
    $data =  mysqli_fetch_array($query);
    return $data['total_added_money'];
}

function reward_income_tbl($user_id)
{
    global $conn;
    global $income_tbl;
    global $c_symbol;
    global $base_url;
    $query = mysqli_query($conn, "SELECT * FROM $income_tbl WHERE user_id = '$user_id' AND category = '3' ORDER BY date DESC ");
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $user_name = user_name($user_id);
        $amount = $c_symbol . $data['amount'];
        $date = date_time($data['date']); ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo  $c_symbol . $amount; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
    <?php
    }
}
// ############## USERS DETAILS TABLE END #########


function total_team_count()
{
    global $conn;
    global $users_tbl;
    global $admin_id;
    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
    }
    return $count;
}

function active_team_count()
{
    global $conn;
    global $users_tbl;
    global $admin_id;
    $query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id != '$admin_id' AND status = 'active' ");
    $count = 0;
    while ($row = mysqli_fetch_array($query)) {
        $count += 1;
    }
    return $count;
}


function blocked_date($user_id)
{
    global $conn;
    global $blocked_users_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $blocked_users_tbl WHERE user_id = '$user_id' ");
    $data = mysqli_fetch_array($query);
    $date =  $data['blocked_date'];
    $date = ($date == '') ? "" : date_time($date);
    return $date;
}




// Show transaction history
function users_transaction_tbl($user_id)
{
    global $conn;
    global $base_url;
    global $transaction_tbl;
    global $c_symbol;


    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE user_id = '$user_id' ORDER BY date DESC ");
    if ($user_id == '') {
        $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl ORDER BY date DESC");
    }
    $count = 0;
    while ($data = mysqli_fetch_array($query)) {
        $count = $count + 1;
        $user_id = $data['user_id'];
        $user_name = user_name($user_id);
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
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_name; ?></a></td>
            <td><a href="<?php echo $base_url . '/admin/user/' . $user_id . '/profile/'; ?>"><?php echo $user_id; ?></a></td>
            <td><?php echo $c_symbol . $amount; ?></td>
            <td><?php echo $c_symbol . $transaction_charge; ?></td>
            <td><?php echo $c_symbol . $net_amount; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $status; ?></td>
        </tr>
<?php
    }
}


function request_count()
{
    global $conn;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'pending' ");
    return mysqli_num_rows($query);
}

function pending_amount($action)
{
    global $conn;
    global $c_symbol;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'pending' ");
    $payable = 0;
    while ($row = mysqli_fetch_array($query)) {
        $payable = $payable + $row['payable'];
    }
    if (empty($action)) {
        $payable = update_data($payable);
    } else {
        $payable = to_decimal($payable);
    }
    return $c_symbol . ($payable);
}

function paid_amount($action)
{
    global $conn;
    global $c_symbol;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'success' ");
    $payable = 0;
    while ($row = mysqli_fetch_array($query)) {
        $payable += $row['payable'];
    }
    if (empty($action)) {
        $payable = update_data($payable);
    } else {
        $payable = to_decimal($payable);
    }

    return $c_symbol . ($payable);
}

function total_charge($action)
{
    global $conn;
    global $c_symbol;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE status = 'success' ");
    $output = 0;
    while ($row = mysqli_fetch_array($query)) {
        $charge = $row['charge'];
        $other_charge = $row['other_charge'];
        $total_charge = $charge + $other_charge;
        $output += $total_charge;
    }

    if (empty($action)) {
        $output = update_data($output);
    } else {
        $output = to_decimal($output);
    }
    return $c_symbol . ($output);
}


function members_wallet($action)
{
    global $conn;
    global $balance_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $balance_tbl");
    $wallet = 0;
    while ($row = mysqli_fetch_array($query)) {
        $wallet += $row['wallet'];
    }
    $wallet = to_decimal($wallet);
    if (empty($action)) {
        $wallet = update_data($wallet);
    }

    return $c_symbol . $wallet;
}
function users_wallet()
{
    global $conn;
    global $balance_tbl;
    global $c_symbol;
    $query = mysqli_query($conn, "SELECT * FROM $balance_tbl");
    $wallet = 0;
    while ($row = mysqli_fetch_array($query)) {
        $wallet += $row['wallet'];
    }
    return to_decimal($wallet);
}

function payment_img($withdraw_id, $user_id)
{
    $status = get_withdraw_status($withdraw_id);
    if ($status == "pending") {
        return user_account_image($user_id);
    } else if ($status == "success") {
        return withdraw_payment_img($withdraw_id);
    }
}

function is_payment_method($action, $withdraw_id)
{
    global $conn;
    global $withdraw_request_tbl;
    $query = mysqli_query($conn, "SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
    $data = mysqli_fetch_array($query);
    $status = $data['status'];
    $payment_method =  explode("||", $data['payment_method']);
    $payment_method = $payment_method[0];
    if ($status == "success") {
        if ($payment_method == $action) {
            echo "checked";
        } else {
            echo "disabled";
        }
    }
}

function total_added_money($action)
{
    global $conn;
    global $transaction_tbl;
    global $c_symbol;
    $amount = 0;
    $query = mysqli_query($conn, "SELECT * FROM $transaction_tbl WHERE category = 'deposit' ");
    while ($row = mysqli_fetch_array($query)) {
        $amount += $row['amount'];
    }
    if (empty($action)) {
        $amount = update_data($amount);
    } else {
        $amount = to_decimal($amount);
    }
    return $c_symbol . $amount;
}
