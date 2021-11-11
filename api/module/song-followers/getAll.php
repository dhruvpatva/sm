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
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin' && isset($_GET['id'])) {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT sf.*,u.first_name,u.last_name,ps.song_info FROM song_followers As sf 
                LEFT JOIN playlist_songs As ps ON ps.id = sf.song_id 
                LEFT JOIN users As u ON u.id = sf.user_id
                WHERE sf.song_id = '". $_GET['id'] ."' AND sf.status != '3' AND (ps.`song_info` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%')";
            $sql = "SELECT sf.*,u.first_name,u.last_name,ps.song_info FROM song_followers As sf 
                LEFT JOIN playlist_songs As ps ON ps.id = sf.song_id 
                LEFT JOIN users As u ON u.id = sf.user_id
                WHERE sf.song_id = '". $_GET['id'] ."' AND sf.status != '3' AND (ps.`song_info` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%') LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT sf.*,u.first_name,u.last_name,ps.song_info FROM song_followers As sf 
                LEFT JOIN playlist_songs As ps ON ps.id = sf.song_id 
                LEFT JOIN users As u ON u.id = sf.user_id 
                WHERE sf.song_id = '". $_GET['id'] ."' AND sf.status != '3'";
            $sql = "SELECT sf.*,u.first_name,u.last_name,ps.song_info FROM song_followers As sf 
                LEFT JOIN playlist_songs As ps ON ps.id = sf.song_id 
                LEFT JOIN users As u ON u.id = sf.user_id 
                WHERE sf.song_id = '". $_GET['id'] ."' AND sf.status != '3' LIMIT $start_from, $num_rec_per_page";
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
