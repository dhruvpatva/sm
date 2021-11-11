<?php
require_once '../../cmnvalidate.php';
$bydirect = true;

if ($bydirect) { 
     if (isset($_REQUEST['title']) && isset($_REQUEST['posttype']) && isset($_REQUEST['sources'])) { 
        $id = $_REQUEST['id'];
        $validation_flag = 0;
        $validation_error_code = NULL;
        $updatevalues = "";
        if (isset($_REQUEST['allValid'])){
            $validate_Files = $_REQUEST['allValid'];
        }
        if(isset($_REQUEST['title']) && $_REQUEST['title'] != ""){
            $title = $obj->replaceUnwantedChars($_REQUEST['title'],1);
            $updatevalues .= "title='".$title."' ,";
        }
        $description = "";
        if (isset($_REQUEST['description']) && $_REQUEST['description'] != ""){
            $description = $obj->replaceUnwantedChars($_REQUEST['description'], 1);
            $updatevalues .= "description='".$description."' ,";
        }
        $parent_id = 0;
        if (isset($_REQUEST['parentpost'])) {
            $parent_id = $_REQUEST['parentpost'];
            $updatevalues .= "parent_id='".$parent_id."' ,";
        }
        if (isset($_REQUEST['posttype'])){
            $posttype = $_REQUEST['posttype'];
            $updatevalues .= "post_type='".$posttype."' ,";
        }
        if (isset($_REQUEST['sources'])){
            $source = $_REQUEST['sources'];
            $updatevalues .= "source_id	='".$source."' ,";
        }
        $status = 1;
        if (isset($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
            $updatevalues .= "status='".$status."' ,";
        }
        $postImg = "no-image.png";
        if (isset($_FILES['image'])) {
            $file_name = time() . $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $response = 'Invalid file extension.';
                $validation_flag = 1;
                $validation_error_code = 'Invalid file extension';
            } else {
                if ($validate_Files == 0){
                    $manipulator = new ImageManipulator($_FILES['image']['tmp_name']);
                    $newImage = $manipulator->resample(400, 400);
                    $res = $manipulator->save(PROJECT_ROOT_UPLOAD . "/users/" . $file_name);
                    $postImg = $file_name;
                    $updatevalues .= "image='".$postImg."' ,";
                }
            }
        }
        $postAudio = NULL;
        if (isset($_FILES['audio'])) {
            $file_name = time() . $_FILES['audio']['name'];
            $file_size = $_FILES['audio']['size'];
            $file_tmp = $_FILES['audio']['tmp_name'];
            $file_type = $_FILES['audio']['type'];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); 
            if (!in_array($ext, array('wav', 'aif', 'mp3', 'mid','mp4'))) {
                $response = 'Invalid file extension.';
                $validation_flag = 1;
                $validation_error_code = 'Invalid file extension'; 
            } else {
                if ($validate_Files == 0){
                    move_uploaded_file($_FILES['audio']['tmp_name'],PROJECT_ROOT_UPLOAD . "/users/audio/" . $file_name);
                    $postAudio = $file_name;
                    $updatevalues .= "audio='".$postAudio."' ,";
                }
            }
        }
        $postVideo = NULL;
        if (isset($_FILES['video'])) {
            $file_name = time() . $_FILES['video']['name'];
            $file_size = $_FILES['video']['size'];
            $file_tmp = $_FILES['video']['tmp_name'];
            $file_type = $_FILES['video']['type']; 
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (!in_array($ext, array('mp4', 'avi', '3gp', 'mpeg', 'wmv','flv'))) {
                $response = 'Invalid file extension.';
                $validation_flag = 1;
                $validation_error_code = 'Invalid file extension';
            } else {
                if ($validate_Files == 0){
                    move_uploaded_file($_FILES['video']['tmp_name'],PROJECT_ROOT_UPLOAD . "/users/video/" . $file_name);
                    $postVideo = $file_name;
                    $updatevalues .= "video='".$postVideo."' ,";
                }
            }
        }
        if ($validation_flag == 0) {
            $query = "SELECT id FROM posts where id!='$id' AND title = '$title' AND post_type = '$posttype' AND source_id = '$source' AND parent_id = '$parent_id' ";
            //$query = "SELECT id FROM playlists where  and name='$name'";
            $query_result = $con->query($query);
            if($query_result->num_rows == 0){
                    $updatevalues = rtrim($updatevalues,",");
                    $query = "UPDATE `posts` SET $updatevalues WHERE id = '$id' ";
                    $query_result = $con->query($query);
                    $result['success'] = 1;
                    $result['data'] = 'success';
                    $result['error'] = 0;
                    $result['error_code'] = NULL;

            } else {
                   $result['success'] = 0;
                   $result['data'] = NULL;
                   $result['error'] = 1;
                   $result['error_code'] = 'Post Already Exists';     
            }
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
if(isset($_SESSION['user'])){
        echo $result;
}
?>
