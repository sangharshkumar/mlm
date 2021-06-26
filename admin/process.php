<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

include("../db.php");
include("../assets/php/functions.php");
$action = $_POST['action'];
switch ($action) {
    case 'admin_login':
        include("assets/php/admin_login.php");
        break;

    case 'dashboard_graph':
        include("assets/php/dashboard_graph.php");
        break;

    case 'change_user_status':
        include("assets/php/change_user_status.php");
        break;


    case 'admin_reply_to_ticket':
        include("assets/php/admin_reply_to_ticket.php");
        break;


    case 'admin_close_ticket':
        include("assets/php/admin_close_ticket.php");
        break;

    case 'load_pin_graph';
        include("assets/php/load_pin_graph.php");
        break;

    case 'load_pin_page';
        include("assets/php/load_pin_page.php");
        break;


    case 'load_income_graph';
        include("assets/php/load_income_graph.php");
        break;

    case 'load_joining_graph';
        include("assets/php/load_joining_graph.php");
        break;


    case 'approve_withdraw';
        include("assets/php/approve_withdraw.php");
        break;
}
