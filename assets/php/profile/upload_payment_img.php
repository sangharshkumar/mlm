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
    case 'payment_img_delete':
        $query = mysqli_query($conn, "UPDATE $users_tbl SET account_image = '' WHERE user_id = '$loggedin_user_id' ");
        if ($query) {
          echo "Image deleted successfully";
        }else{
            echo "Something went wrong";
        }
    break;
    case 'preview_payment_img':
        $img_src =  user_account_image($loggedin_user_id);
        echo '<img id="imageprev" src="' . $img_src . '" >';
        break;
    case 'image_upload':

        $file = $_FILES['payment'];
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
            } elseif (($file['size'] > 4000000)) {
                echo "Image size exceeds 4MB";
            } else {
                $rand = get_uuid();
                $destfile = '../images/users/' . date('mjYHis') . $rand . $filename;
                $url =  date('mjYHis') . $rand . $filename;
                compressImage($filepath, $destfile, 60);
                $query = mysqli_query($conn, "UPDATE $users_tbl SET account_image = '$url' WHERE user_id = '$loggedin_user_id' ");
               if ($query) {
                 echo "Image uploaded successfully";
               }
            }
        } else {
            echo "fileerror";
        }
        break;
    case 'upload_option':
        $img_src = user_account_image($loggedin_user_id);
?>
        <div class="pop_img_upload" id="payment_img_upload_container">

            <div class="pop-imgupload">
                <div class="pop-imgupload-header">
                    <span>Change image</span>
                    <button id="close_pop_imgupload" class="close-pop-imgupload" type="button">×</button>
                </div>
                <div class="pop-imgupload-body">
                    <label class="btn bg-primary">
                        <i class="fas fa-upload"></i>
                        &nbsp; Upload<input type="file" class="sr-only" id="payment_img_input" name="image" accept="image/*"></label>
                        <?php
                        if ($img_src !== $base_url.'/assets/images/users/') {
                            ?>
                            <button id="payment_img_edit" class="btn bg-success">
                                <i class="fas fa-edit"></i>
                                &nbsp;
                                <span>Edit</span></button>
                            <button id="payment_img_del" class="btn bg-danger">
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