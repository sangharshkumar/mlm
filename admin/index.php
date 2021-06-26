<?php
include("../db.php");
include("../assets/php/functions.php");
if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}
header("location:$base_url/admin/dashboard/");
exit();