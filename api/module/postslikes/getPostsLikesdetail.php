<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
        $id = $_REQUEST['id'];
        // Get posts likes detail
        //$query = "SELECT id,name,created,status FROM post_types where id=$id";
        $query = "SELECT p_like.*,u.first_name,u.last_name,p.title FROM `post_likes` As p_like
                LEFT JOIN `posts` As p ON p.id = p_like.post_id
                LEFT JOIN `users` As u ON u.id = p_like.user_id WHERE p_like.id = '$id' ";
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
