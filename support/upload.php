<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

include("../db.php");

// upload.php
$my_file = $_FILES['my_file'];
$file_path = $my_file['tmp_name']; // temporary upload path of the file
$file_name = $_POST['name']; // desired name of the file
$ext = substr(strrchr($file_name, '.'), 1);
$file_name = guidv4().".".$ext;

move_uploaded_file($file_path, '../assets/images/users/' . basename($file_name)); // save the file at `img/FILE_NAME`

echo $file_name;


function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
