<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) { 
     if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        
        $updatevalues = "";
        if(isset($_REQUEST['status']) && $_REQUEST['status'] != ""){
             $updatevalues .= "status='".$_REQUEST['status']."' ,";
        }
        $updatevalues = rtrim($updatevalues,",");
        $query = "UPDATE `post_comment_likes` SET $updatevalues WHERE id = '$id' ";
        $query_result = $con->query($query);
        $result['success'] = 1;
        $result['data'] = 'success';
        $result['error'] = 0;
        $result['error_code'] = NULL;
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
}else if(isset($_REQUEST['is_mobile_api'])){
        echo $result;
}
?>