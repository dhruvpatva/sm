<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
     $created = $obj->getTimeZone('Y-m-d H:i:s');
     if (isset($_REQUEST['name'])) {
          $name = $obj->replaceUnwantedChars($_REQUEST['name'],1);
          
          $status = 1;
          if (isset($_REQUEST['status'])){
               $status = $_REQUEST['status'];
          }
          $query = "SELECT id FROM playlists where name='$name'";
          $query_result = $con->query($query);
          if ($query_result->num_rows == 0) {
               $query = "INSERT INTO playlists(user_id,name,status,created) VALUES ('".$_SESSION['user']['user_id']."','$name','$status','$created')";
               $query_result = $con->query($query);
               $result['success'] = 1;
               $result['data'] = 'success';
               $result['error'] = 0;
               $result['error_code'] = NULL;
          } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Playlists Already Exists';
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