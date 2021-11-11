<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {    
     $created = $obj->getTimeZone('Y-m-d H:i:s');
     if (isset($_REQUEST['playlists']) && isset($_REQUEST['sources']) && isset($_REQUEST['song_info'])) {
          $playlists = $_REQUEST['playlists'];
          $sources = $_REQUEST['sources'];
          $song_info = "";
          if(isset($_REQUEST['song_info']) && $_REQUEST['song_info'] != ""){
               $song_info = $obj->replaceUnwantedChars($_REQUEST['song_info'],1);
          }
          $status = 1;
          if (isset($_REQUEST['status'])){
               $status = $_REQUEST['status'];
          }
          $query = "SELECT id FROM playlist_songs where playlist_id='$playlists' AND source_id='$sources' AND song_info='$song_info'";
          $query_result = $con->query($query);
          if ($query_result->num_rows == 0) {
               $query = "INSERT INTO playlist_songs(playlist_id,source_id,song_info,status,created) VALUES ('$playlists','$sources','$song_info','$status','$created')";
               $query_result = $con->query($query);
               $result['success'] = 1;
               $result['data'] = 'success';
               $result['error'] = 0;
               $result['error_code'] = NULL;
          } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Playlist Songs Already Exists';
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