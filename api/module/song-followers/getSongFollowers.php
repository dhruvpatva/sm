<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
        $id = $_REQUEST['id'];
        $query = "SELECT sf.*,u.first_name,u.last_name,ps.playlist_id,ps.song_info FROM song_followers As sf 
                  INNER JOIN users As u ON u.id = user_id
                  LEFT JOIN playlist_songs As ps ON ps.id = sf.song_id
                  WHERE sf.id = '$id' AND sf.status != '3' ";
        $query_result = $con->query($query);
        if($query_result->num_rows > 0){
                $resulted_data = $query_result->fetch_assoc();
                $result['success'] = 1;
                $result['data'] = $resulted_data;
                $result['error'] = 0;
                $result['error_code'] = NULL;
        }
}
$result = json_encode($result);
if(isset($_SESSION['user'])){
        echo $result;
}
?>
