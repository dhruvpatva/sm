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
            $sqlTotal = "SELECT User_follow.*,User.first_name As u_first_name,User.last_name As u_last_name,Follow_user.first_name As follow_u_first_name,Follow_user.last_name As follow_u_last_name FROM user_follow As User_follow 
                INNER JOIN users As User ON User.id = User_follow.user_id
                INNER JOIN users As Follow_user ON Follow_user.id = User_follow.follow_user_id
                WHERE User_follow.user_id = '" . $_GET['id'] . "' AND ( CONCAT(User.`first_name`,User.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%' OR CONCAT(Follow_user.`first_name`,Follow_user.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%')";
            $sql = "SELECT User_follow.*,User.first_name As u_first_name,User.last_name As u_last_name,Follow_user.first_name As follow_u_first_name,Follow_user.last_name As follow_u_last_name FROM user_follow As User_follow 
                INNER JOIN users As User ON User.id = User_follow.user_id
                INNER JOIN users As Follow_user ON Follow_user.id = User_follow.follow_user_id
                WHERE User_follow.user_id = '" . $_GET['id'] . "' AND ( CONCAT(User.`first_name`,User.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%' OR CONCAT(Follow_user.`first_name`,Follow_user.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%')";
        } else {
            $sqlTotal = "SELECT * FROM user_follow As User_follow 
                INNER JOIN users As User ON User.id = User_follow.user_id
                INNER JOIN users As Follow_user ON Follow_user.id = User_follow.follow_user_id WHERE User_follow.user_id = '" . $_GET['id'] . "'";
            $sql = "SELECT User_follow.*,User.first_name As u_first_name,User.last_name As u_last_name,Follow_user.first_name As follow_u_first_name,Follow_user.last_name As follow_u_last_name FROM user_follow As User_follow 
                INNER JOIN users As User ON User.id = User_follow.user_id
                INNER JOIN users As Follow_user ON Follow_user.id = User_follow.follow_user_id
                WHERE User_follow.user_id = '" . $_GET['id'] . "' LIMIT $start_from, $num_rec_per_page";
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
