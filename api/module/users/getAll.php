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
        // Get all Users
        /*if($_SESSION['user']['userRole'] == 'admin'){
                $query = "SELECT * FROM users where role != 0";
        } else {
                $query = "SELECT * FROM users where role != 0";
        }*/
        
        if (isset($_GET["page"])) {
                $page  = $_GET["page"];
            } else {
                $page=1;
            } 
            $start_from = ($page-1) * $num_rec_per_page;
            if (!empty($_GET["search"])) { 
                $sqlTotal = "SELECT * FROM `users` WHERE `role` != '0' AND (`first_name` LIKE '%" . $_GET["search"] . "%' OR `last_name` LIKE '%" . $_GET["search"] . "%' OR `email` LIKE '%" . $_GET["search"] . "%' OR `mobile_number` LIKE '%" . $_GET['search'] . "%')";
                $sql = "SELECT User.*,COUNT(User_follow.user_id) As tot_user_follow FROM `users` As User
                    LEFT JOIN user_follow As User_follow ON User_follow.user_id = User.id
                    WHERE User.`role` != '0' AND (User.`first_name` LIKE '%" . $_GET["search"] . "%' OR User.`last_name` LIKE '%" . $_GET["search"] . "%' OR User.`email` LIKE '%" . $_GET["search"] . "%' OR User.`mobile_number` LIKE '%" . $_GET['search'] . "%') GROUP BY User.id LIMIT $start_from, $num_rec_per_page";
            } else {
                $sqlTotal = "SELECT * FROM `users` WHERE `role` != '0' ";
                $sql = "SELECT User.*,COUNT(User_follow.user_id) As tot_user_follow,COUNT(User_Libraries.user_id) As tot_user_libraries FROM `users` As User 
                        LEFT JOIN user_follow As User_follow ON User_follow.user_id = User.id
                        LEFT JOIN user_libraries As User_Libraries ON User_Libraries.user_id = User.id
                        WHERE User.`role` != '0' GROUP BY User.id LIMIT $start_from, $num_rec_per_page";
            } 
            $query_result = $con->query($sql);
            $resulted_data = array();
            while ($rows = $query_result->fetch_assoc()) {
                //$rows['dob'] = date("d-m-Y",strtotime($rows['dob']));
                $resulted_data[] = $rows;
            }
            
            $sqlTotal_result = $con->query($sqlTotal);
            $result['total'] = $sqlTotal_result->num_rows;
        
        //
        
        
        //$query_result = $con->query($query);
        //$resulted_data = array();
        //while ($rows = $query_result->fetch_assoc()) {
        //        $rows['dob'] = date("d-m-Y",strtotime($rows['dob']));
        //        $resulted_data[] = $rows;
        //}
        $result['success'] = 1;
        $result['data'] = $resulted_data;
        $result['error'] = 0;
        $result['error_code'] = NULL;
}
$result = json_encode($result);
echo $result;
?>
