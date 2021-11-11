<?php
require_once '../../cmnvalidate.php';
require_once '../../libs/image/ImageManipulator.php';
$bydirect = true;
if ($bydirect) {    
    $created = $obj->getTimeZone('Y-m-d H:i:s');
    if (isset($_REQUEST['title']) && isset($_REQUEST['posttype']) && isset($_REQUEST['sources'])) {
        $validation_flag = 0;
        $validation_error_code = NULL;
        $validate_Files = $_REQUEST['allValid'];
        $title = $obj->replaceUnwantedChars($_REQUEST['title'], 1); 
        $description = "";
        if (isset($_REQUEST['description'])){
            $description = $obj->replaceUnwantedChars($_REQUEST['description'], 1);
        }
        $parent_id = 0;
        if (isset($_REQUEST['parentpost'])) {
            $parent_id = $_REQUEST['parentpost'];
        }
        $posttype = $_REQUEST['posttype'];
        $source = $_REQUEST['sources'];
        $status = 1;
        if (isset($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
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
                }
            }
        }
        if ($validation_flag == 0) {
            $query = "SELECT id FROM posts where title = '$title' AND post_type = '$posttype' AND source_id = '$source' AND parent_id = '$parent_id' ";
            $query_result = $con->query($query);
            if ($query_result->num_rows == 0) {
                $query = "INSERT INTO posts(parent_id,post_type,source_id,user_id,title,description,image,video,audio,status,created) VALUES ('$parent_id','$posttype','$source','" . $_SESSION['user']['user_id'] . "','$title','$description','$postImg','$postVideo','$postAudio','$status','$created')";
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
        }else{
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
if (isset($_SESSION['user'])) {
    echo $result;
}
?>