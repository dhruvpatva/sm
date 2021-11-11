<?php

require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
     $created = $obj->getTimeZone('Y-m-d H:i:s');
     if (isset($_REQUEST['title'])) {
          $title = $obj->replaceUnwantedChars($_REQUEST['title'],1);
          
          $status = 1;
          if (isset($_REQUEST['status'])){
               $status = $_REQUEST['status'];
          }
          $query = "SELECT id FROM post_types where name='$title'";
          $query_result = $con->query($query);
          if ($query_result->num_rows == 0) {
               $query = "INSERT INTO post_types(name,status,created) VALUES ('$title','$status','$created')";
               $query_result = $con->query($query);
               $result['success'] = 1;
               $result['data'] = 'success';
               $result['error'] = 0;
               $result['error_code'] = NULL;
          } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Post Type Already Exists';
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
} else if (isset($_REQUEST['is_mobile_api'])) {
     echo $result;
}
?>