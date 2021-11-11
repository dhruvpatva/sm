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
        // Get all goals
        if (isset($_GET["page"]) && $_SESSION['user']['userRole'] == 'admin') {
                $page  = $_GET["page"];
            } else {
                $page=1;
            }
        $start_from = ($page-1) * $num_rec_per_page;
        if (!empty($_GET["search"])) { 
            $sqlTotal = "SELECT * FROM `sources` WHERE (`name` LIKE '%" . $_GET["search"] . "%')";
            $sql = "SELECT * FROM `sources` WHERE (`name` LIKE '%" . $_GET["search"] . "%') LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT * FROM `sources` ";
            $sql = "SELECT * FROM `sources` LIMIT $start_from, $num_rec_per_page";
        }
        $query_result = $con->query($sql);
        $resulted_data = array();
        while ($rows = $query_result->fetch_assoc()) {
            $resulted_data[] = $rows;
        }

        $sqlTotal_result = $con->query($sqlTotal);
        $result['total'] = $sqlTotal_result->num_rows;
    
    
        /*if($_SESSION['user']['userRole'] == 'admin'){
                $query = "SELECT id,name,created,status FROM sources";
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
