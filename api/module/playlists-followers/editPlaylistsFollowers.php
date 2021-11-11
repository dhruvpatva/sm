<?php
require_once '../../cmnvalidate.php';
$bydirect = true;

if ($bydirect) { 
     if (isset($_REQUEST['id']) && isset($_REQUEST['playlist_id'])) {
        $id = $_REQUEST['id'];
        $playlist_id = $_REQUEST['playlist_id'];
        
        //$query = "SELECT id FROM playlists where id!=$id and name='$name'";
        //$query_result = $con->query($query);
        //if($query_result->num_rows == 0){
                $validation_flag = 0;
                $validation_error_code = NULL;
                $updatevalues = "";
                if(isset($_REQUEST['playlist_id']) && $_REQUEST['playlist_id'] != ""){
                     $updatevalues .= "playlist_id='".$playlist_id."' ,";
                }
                if(isset($_REQUEST['status']) && $_REQUEST['status'] != ""){
                     $updatevalues .= "status='".$_REQUEST['status']."' ,";
                }
                $updatevalues = rtrim($updatevalues,",");
                if ($validation_flag == 0) {
                    $query = "UPDATE `playlist_followers` SET $updatevalues WHERE id = '$id' ";
                    $query_result = $con->query($query);
                    $result['success'] = 1;
                    $result['data'] = 'success';
                    $result['error'] = 0;
                    $result['error_code'] = NULL;
                } else {
                    $result['success'] = 0;
                    $result['data'] = NULL;
                    $result['error'] = 1;
                    $result['error_code'] = $validation_error_code;
                }
        //} else {
        //       $result['success'] = 0;
        //       $result['data'] = NULL;
        //       $result['error'] = 1;
        //       $result['error_code'] = 'Playlists Already Exists';     
       // }
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