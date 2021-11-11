<?php
require_once '../../cmnvalidate.php';
require_once '../../libs/image/ImageManipulator.php';
$bydirect = true;
if (isset($_REQUEST['is_mobile_api'])) {
     if ($result['success'] == 1) {
          $bydirect = true;
     } else {
          $bydirect = false;
     }
}
if ($bydirect) {
     if (isset($_REQUEST['userid'])) {
          $userid = $_REQUEST['userid'];
          $validation_flag = 0;
          $validation_error_code = NULL;

          if (isset($_FILES['profile_image'])) {
               $file_name = time() . $_FILES['profile_image']['name'];
               $file_size = $_FILES['profile_image']['size'];
               $file_tmp = $_FILES['profile_image']['tmp_name'];
               $file_type = $_FILES['profile_image']['type'];
               $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
               if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                    $response = 'Invalid file extension.';
                    $validation_flag = 1;
                    $validation_error_code = 'Invalid file extension.';
               } else {
                    $manipulator = new ImageManipulator($_FILES['profile_image']['tmp_name']);
                    // resizing to 200x200
                    $newImage = $manipulator->resample(400, 400);
                    $res = $manipulator->save(PROJECT_ROOT_UPLOAD . "/users/" . $file_name);
                    $profile_image = $file_name;
               }
          }
          if ($validation_flag == 0) {
               $query = "UPDATE users SET  profile_img='$profile_image' WHERE id = '$userid' ";
               $query_result = $con->query($query);
               $profileimage = SITE_ROOT."/uploads/users/".$profile_image;
               $result['success'] = 1;
               $result['data'] = $profileimage;
               $result['error'] = 0;
               $result['error_code'] = NULL;
          } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = $validation_error_code;
          }
     } else {
          $result['success'] = 0;
          $result['data'] = NULL;
          $result['error'] = 1;
          $result['error_code'] = 'Required Parameter Are Missing';
     }
}
$result = json_encode($result);
echo $result;
?>