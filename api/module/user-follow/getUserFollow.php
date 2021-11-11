<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
        $id = $_REQUEST['id'];
        $query = "SELECT User_follow.*,User.first_name,User.last_name,Follow_user.first_name As follow_user_fname,Follow_user.last_name As follow_user_lname FROM user_follow As User_follow 
                LEFT JOIN users As User ON User.id = User_follow.user_id
                LEFT JOIN users As Follow_user ON Follow_user.id = User_follow.follow_user_id
                where User_follow.user_id=$id";
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
