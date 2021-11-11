<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
if ($bydirect) {
        $id = $_REQUEST['id'];
        $query = "SELECT Post.*,User.first_name,User.last_name FROM posts As Post INNER JOIN users As User ON User.id = Post.user_id where Post.id=$id";
        $query_result = $con->query($query);
        if($query_result->num_rows > 0){
                $resulted_data = $query_result->fetch_assoc();
                $post_image = SITE_ROOT."/uploads/users/no-image.png";
                if($resulted_data['image'] != ""){
                     $post_image = SITE_ROOT."/uploads/users/".$resulted_data['image'];
                }
                $post_video = "";
                if($resulted_data['video'] != ""){
                    $post_video = SITE_ROOT."/uploads/users/video/".$resulted_data['video']; 
                }
                $post_audio = "";
                if($resulted_data['audio'] != ""){
                    $post_audio = SITE_ROOT."/uploads/users/audio/".$resulted_data['audio']; 
                }
                $resulted_data['image'] = $post_image;
                $resulted_data['video'] = $post_video;
                $resulted_data['audio'] = $post_audio;
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
