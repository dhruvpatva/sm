<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) { 
     $created = $obj->getTimeZone('Y-m-d H:i:s');
     if (isset($_REQUEST['playlists'])) {
          $playlist_id = $_REQUEST['playlists'];
          $status = 1;
          if (isset($_REQUEST['status'])){
               $status = $_REQUEST['status'];
          }
          //$query = "SELECT id FROM playlists where name='$name'";
          //$query_result = $con->query($query);
          //if ($query_result->num_rows == 0) {
               $query = "INSERT INTO playlist_followers(playlist_id,user_id,status,created) VALUES ('$playlist_id','".$_SESSION['user']['user_id']."','$status','$created')";
               $query_result = $con->query($query);
               $result['success'] = 1;
               $result['data'] = 'success';
               $result['error'] = 0;
               $result['error_code'] = NULL;
          //} else {
          //     $result['success'] = 0;
          //     $result['data'] = NULL;
          //     $result['error'] = 1;
          //     $result['error_code'] = 'Playlists Already Exists';
          //}
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