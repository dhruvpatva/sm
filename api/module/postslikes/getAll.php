<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
$num_rec_per_page = 20;
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
        // Get all posts
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin' && isset($_GET['id'])) {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT p_like.*,u.first_name,u.last_name,p.title FROM `post_likes` As p_like
                LEFT JOIN `posts` As p ON p.id = p_like.post_id
                LEFT JOIN `users` As u ON u.id = p_like.user_id
                WHERE p_like.post_id = '".$_GET['id']."' AND (p.`title` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET['search']) . "%') AND p_like.status != '3' ";
            $sql = "SELECT p_like.*,u.first_name,u.last_name,p.title FROM `post_likes` As p_like
                LEFT JOIN `posts` As p ON p.id = p_like.post_id
                LEFT JOIN `users` As u ON u.id = p_like.user_id
                WHERE p_like.post_id = '".$_GET['id']."' AND (p.`title` LIKE '%" . $_GET["search"] . "%' OR CONCAT(u.`first_name`,u.`last_name`) LIKE '%" . str_replace(' ','',$_GET['search']) . "%') AND p_like.status != '3' LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT * FROM `post_likes` As p_like
                LEFT JOIN `posts` As p ON p.id = p_like.post_id
                LEFT JOIN `users` As u ON u.id = p_like.user_id WHERE p_like.post_id = '".$_GET['id']."' AND p_like.status != '3' ";
            $sql = "SELECT p_like.*,u.first_name,u.last_name,p.title FROM `post_likes` As p_like
                LEFT JOIN `posts` As p ON p.id = p_like.post_id
                LEFT JOIN `users` As u ON u.id = p_like.user_id WHERE p_like.post_id = '".$_GET['id']."' AND p_like.status != '3' LIMIT $start_from, $num_rec_per_page";
        }
        $query_result = $con->query($sql);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
            $resulted_data[] = $rows;
        }
        $sqlTotal_result = $con->query($sqlTotal);
        $result['total'] = $sqlTotal_result->num_rows;
            
    
        //if($_SESSION['user']['userRole'] == 'admin'){
        //        $query = "SELECT id,name,created,status FROM post_types";
        //} 
        //$query_result = $con->query($query);
        //$resulted_data = array();
        //while ($rows = $query_result->fetch_assoc()) {
        //        $resulted_data[] = $rows;
        //}
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
