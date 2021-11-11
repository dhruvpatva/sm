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
        // Get all playlists songs
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin') {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT ps.id,ps.playlist_id,ps.source_id,ps.song_info,ps.created,ps.status,p.name As playlist,s.name As source FROM playlist_songs As ps 
                    INNER JOIN playlists AS p ON p.id = ps.playlist_id 
                    LEFT JOIN sources As s ON s.id = ps.source_id
                    WHERE (ps.`song_info` LIKE '%" . $_GET["search"] . "%' OR p.`name` LIKE '%" . $_GET["search"] . "%' OR s.`name` LIKE '%" . $_GET["search"] . "%')";
            $sql = "SELECT ps.id,ps.playlist_id,ps.source_id,ps.song_info,ps.created,ps.status,p.name As playlist,s.name As source FROM playlist_songs As ps 
                    INNER JOIN playlists AS p ON p.id = ps.playlist_id 
                    LEFT JOIN sources As s ON s.id = ps.source_id
                    WHERE (ps.`song_info` LIKE '%" . $_GET["search"] . "%' OR p.`name` LIKE '%" . $_GET["search"] . "%' OR s.`name` LIKE '%" . $_GET["search"] . "%') LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT ps.id,ps.playlist_id,ps.source_id,ps.song_info,ps.created,ps.status,p.name As playlist,s.name As source FROM playlist_songs As ps 
                    INNER JOIN playlists AS p ON p.id = ps.playlist_id 
                    LEFT JOIN sources As s ON s.id = ps.source_id";
            $sql = "SELECT ps.id,ps.playlist_id,ps.source_id,ps.song_info,ps.created,ps.status,p.name As playlist,s.name As source,
                    COUNT(sf.song_id) As tot_song_follower FROM playlist_songs As ps 
                    INNER JOIN playlists AS p ON p.id = ps.playlist_id 
                    LEFT JOIN sources As s ON s.id = ps.source_id
                    LEFT JOIN song_followers As sf ON sf.song_id = ps.id AND sf.status != '3'
                    GROUP BY sf.song_id LIMIT $start_from, $num_rec_per_page";
        }
        $query_result = $con->query($sql);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
            $resulted_data[] = $rows;
        }

        $sqlTotal_result = $con->query($sqlTotal);
        $result['total'] = $sqlTotal_result->num_rows;
        
        /*if($_SESSION['user']['userRole'] == 'admin'){
                $query = "SELECT ps.id,ps.playlist_id,ps.source_id,ps.song_info,ps.created,ps.status,p.name As playlist,s.name As source FROM playlist_songs As ps 
                    INNER JOIN playlists AS p ON p.id = ps.playlist_id 
                    LEFT JOIN sources As s ON s.id = ps.source_id";
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
