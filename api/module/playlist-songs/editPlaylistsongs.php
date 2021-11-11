<?php
require_once '../../cmnvalidate.php';
$bydirect = true;

if ($bydirect) { //print_R($_REQUEST);exit;
     if (isset($_REQUEST['id']) && isset($_REQUEST['song_info'])) {
        $id = $_REQUEST['id'];
        $song_info = $obj->replaceUnwantedChars($_REQUEST['song_info'],1);
        $playlists = $_REQUEST['playlists'];
        $sources = $_REQUEST['sources'];
        $query = "SELECT id FROM playlist_songs where id!='$id' AND playlist_id='$playlists' AND source_id='$sources' AND song_info='$song_info'";
        $query_result = $con->query($query);
        if($query_result->num_rows == 0){
                $validation_flag = 0;
                $validation_error_code = NULL;
                $updatevalues = "";
                if(isset($_REQUEST['playlists']) && $_REQUEST['playlists'] != ""){
                     $updatevalues .= "playlist_id='".$playlists."' ,";
                }
                if(isset($_REQUEST['sources']) && $_REQUEST['sources'] != ""){
                     $updatevalues .= "source_id='".$sources."' ,";
                }
                if(isset($_REQUEST['song_info']) && $_REQUEST['song_info'] != ""){
                     $updatevalues .= "song_info='".$song_info."' ,";
                }
                if(isset($_REQUEST['status']) && $_REQUEST['status'] != ""){
                     $updatevalues .= "status='".$_REQUEST['status']."' ,";
                }
                $updatevalues = rtrim($updatevalues,",");
                if ($validation_flag == 0) {
                    $query = "UPDATE `playlist_songs` SET $updatevalues WHERE id = '$id' ";
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
        } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Playlist Song Already Exists';     
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