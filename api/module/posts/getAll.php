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
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin') {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT Post.*,Post_Type.name As PostType,Source.name As SourceTitle,User.first_name,User.last_name FROM posts As Post 
                    LEFT JOIN post_types As Post_Type ON Post_Type.id = Post.post_type 
                    LEFT JOIN sources As Source ON Source.id = Post.source_id 
                    LEFT JOIN users As User ON User.id = Post.user_id
                    WHERE Post.status != '3' AND (Post.`title` LIKE '%" . $_GET["search"] . "%' OR Post_Type.`name` Like '%" . $_GET['search'] . "%' OR Source.`name` Like '%" . $_GET['search'] . "%' OR CONCAT(User.`first_name`,User.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%')";
            $sql = "SELECT Post.*,Post_Type.name As PostType,Source.name As SourceTitle,User.first_name,User.last_name,
                    COUNT(Post_like.post_id) As tot_post_like,COUNT(Post_comment.post_id) As tot_post_comment
                    FROM posts As Post 
                    LEFT JOIN post_types As Post_Type ON Post_Type.id = Post.post_type 
                    LEFT JOIN sources As Source ON Source.id = Post.source_id 
                    LEFT JOIN users As User ON User.id = Post.user_id
                    LEFT JOIN post_likes As Post_like ON Post_like.post_id = Post.id AND Post_like.status != '3'
                    LEFT JOIN post_comments As Post_comment ON Post_comment.post_id = Post.id AND Post_comment.status != '3'
                    WHERE Post.status != '3' AND (Post.`title` LIKE '%" . $_GET["search"] . "%' OR Post_Type.`name` Like '%" . $_GET['search'] . "%' OR Source.`name` Like '%" . $_GET['search'] . "%' OR CONCAT(User.`first_name`,User.`last_name`) LIKE '%" . str_replace(' ','',$_GET["search"]) . "%') GROUP BY Post.id LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT Post.*,Post_Type.name As PostType,Source.name As SourceTitle,User.first_name,User.last_name FROM posts As Post 
                    LEFT JOIN post_types As Post_Type ON Post_Type.id = Post.post_type 
                    LEFT JOIN sources As Source ON Source.id = Post.source_id 
                    LEFT JOIN users As User ON User.id = Post.user_id WHERE Post.status != '3'";
            $sql = "SELECT Post.*,Post_Type.name As PostType,Source.name As SourceTitle,User.first_name,User.last_name,
                    COUNT(Post_like.post_id) As tot_post_like,COUNT(Post_comment.post_id) As tot_post_comment
                    FROM posts As Post 
                    LEFT JOIN post_types As Post_Type ON Post_Type.id = Post.post_type 
                    LEFT JOIN sources As Source ON Source.id = Post.source_id 
                    LEFT JOIN users As User ON User.id = Post.user_id
                    LEFT JOIN post_likes As Post_like ON Post_like.post_id = Post.id AND Post_like.status != '3'
                    LEFT JOIN post_comments As Post_comment ON Post_comment.post_id = Post.id AND Post_comment.status != '3'
                    WHERE Post.status != '3' GROUP BY Post.id
                    LIMIT $start_from, $num_rec_per_page";
        }
        //echo $sql;exit;
        $query_result = $con->query($sql);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
            $resulted_data[] = $rows;
        }

        $sqlTotal_result = $con->query($sqlTotal);
        $result['total'] = $sqlTotal_result->num_rows;
        
        /*if($_SESSION['user']['userRole'] == 'admin'){
                $query = "SELECT Post.*,Post_Type.name As PostTitle,Source.name As SourceTitle,User.first_name,User.last_name FROM posts As Post 
                    LEFT JOIN post_types As Post_Type ON Post_Type.id = Post.post_type 
                    LEFT JOIN sources As Source ON Source.id = Post.source_id 
                    LEFT JOIN users As User ON User.id = Post.user_id ";
                    
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
