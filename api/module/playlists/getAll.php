<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
$num_rec_per_page= 20;
if (isset($_REQUEST['is_mobile_api'])) {
        if ($result['success'] == 1) {
                $bydirect = true;
        } else {
                $bydirect = false;
        }
        $params = array();
        $userid = $_REQUEST['userid'];
}
if ($bydirect) {
        // Get all playlists
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin') {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT p.id,p.name,p.created,p.status,u.first_name,u.last_name FROM playlists As p 
                INNER JOIN users As u ON u.id = p.user_id 
                WHERE p.status != '3' AND (p.`name` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%')";
            $sql = "SELECT p.id,p.name,p.created,p.status,u.first_name,u.last_name,
                COUNT(Playlist_follower.playlist_id) As tot_playlist_follower,COUNT(Playlist_song.playlist_id) As tot_playlist_song FROM playlists As p 
                INNER JOIN users As u ON u.id = p.user_id 
                LEFT JOIN playlist_followers As Playlist_follower ON Playlist_follower.playlist_id = p.id AND Playlist_follower.status != '3'
                LEFT JOIN playlist_songs As Playlist_song ON Playlist_song.playlist_id = p.id AND Playlist_song.status != '3'
                WHERE p.status != '3' AND (p.`name` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%') GROUP BY p.id LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT p.id,p.name,p.created,p.status,u.first_name,u.last_name FROM playlists As p 
                INNER JOIN users As u ON u.id = p.user_id WHERE p.status != '3' ";
            $sql = "SELECT p.id,p.name,p.created,p.status,u.first_name,u.last_name,
                COUNT(Playlist_follower.playlist_id) As tot_playlist_follower,COUNT(Playlist_song.playlist_id) As tot_playlist_song FROM playlists As p 
                INNER JOIN users As u ON u.id = p.user_id
                LEFT JOIN playlist_followers As Playlist_follower ON Playlist_follower.playlist_id = p.id AND Playlist_follower.status != '3'
                LEFT JOIN playlist_songs As Playlist_song ON Playlist_song.playlist_id = p.id AND Playlist_song.status != '3'
                WHERE p.status != '3' GROUP BY p.id LIMIT $start_from, $num_rec_per_page";
        }
        $query_result = $con->query($sql);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
            $resulted_data[] = $rows;
        }

        $sqlTotal_result = $con->query($sqlTotal);
        $result['total'] = $sqlTotal_result->num_rows;
        
        /*if($_SESSION['user']['userRole'] == 'admin'){
                $query = "SELECT p.id,p.name,p.created,p.status,u.first_name,u.last_name FROM playlists As p INNER JOIN users As u ON u.id = p.user_id";
        } 
        $query_result = $con->query($query);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
                 $resulted_data[] = $rows;
        }*/
        $result['success'] = 1;
        $result['data'] = $resulted_data;
        $result['error'] = 0;
        $result['error_code'] = NULL;
}
$result = json_encode($result);
if($_SESSION['user']['userRole'] == 'admin'){
     echo $result;
}
?>
