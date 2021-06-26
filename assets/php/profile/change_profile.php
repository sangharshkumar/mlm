<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!is_loggedin()) {
    echo "You must login to change the profile";
    exit();
}


if (!isset($_POST['condition'])) {
    exit();
}

$condition = $_POST['condition'];
switch ($condition) {
    case 'profile_img_delete':
            $query = mysqli_query($conn, "UPDATE $users_tbl SET user_image = 'avatar.jpg' WHERE user_id = '$loggedin_user_id' ");
            echo user_image($loggedin_user_id);
        break;
    case 'preview_profile_img':
        $img_src =  user_image($loggedin_user_id);
        echo '<img id="imageprev" src="' . $img_src . '" >';
        break;
    case 'image_upload':

        $file = $_FILES['avatar'];
        $file = preg_replace("/\s+/", "_", $file);
        $filename = $file['name'];
        $filepath = $file['tmp_name'];
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileinfo = getimagesize($file['tmp_name']);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $fileerror = $file['error'];
        $allowed_image_extension = array("png", "jpg", "jpeg", "gif", "PNG", "JPG", "JPEG", "GIF");
        if ($fileerror == 0) {
            if (!in_array($file_extension, $allowed_image_extension)) {
                echo "Upload valid images. Only PNG, JPG, GIF and JPEG are allowed.";
            } else if (($file['size'] > 4000000)) {
                echo "Image size exceeds 4MB";
            } else {
                $rand = get_uuid();
                $destfile = '../images/users/' . date('mjYHis') . $rand . $filename;
                $url =  date('mjYHis') . $rand . $filename;
                compressImage($filepath, $destfile, 60);
                mysqli_query($conn, "UPDATE $users_tbl SET user_image = '$url' WHERE user_id = '$loggedin_user_id' ");
                echo '<img id="img" alt="" src="image/' . $url . '" />';
            }
        } else {
            echo "fileerror";
        }
        break;
    case 'profile_option':
        $img_src = user_image($loggedin_user_id);
?>
        <div class="pop_img_upload" id="pop_img_upload">

            <div class="pop-imgupload">
                <div class="pop-imgupload-header">
                    <span>Change avatar</span>
                    <button id="close_pop_imgupload" class="close-pop-imgupload" type="button">×</button>
                </div>
                <div class="pop-imgupload-body">
                    <label class="btn bg-primary">
                        <i class="fas fa-upload"></i>
                        &nbsp; Upload<input type="file" class="sr-only" id="img_upload_input" name="image" accept="image/*"></label>
                        <button id="camera_img" class="btn bg-info" data-backdrop="static" data-toggle="modal" data-target="#cameraModal">
                            <i class="fas fa-camera"></i>
                            &nbsp; Camera</button>
                        <?php
                        if ($img_src != $base_url . '/assets/images/web/avatar.jpg') {
                        ?>
                            <button id="edit_img" class="btn bg-success">
                                <i class="fas fa-edit"></i>
                                &nbsp;
                                <span>Edit</span></button>
                            <button id="delete_img" class="btn bg-danger">
                                <i class="fas fa-times"></i>
                                &nbsp;
                                <span>Delete</span></button>
                        <?php
                        }
                        ?>
                </div>
            </div>

        </div>
<?php
        break;

    default:
        # code...
        break;
}



?>