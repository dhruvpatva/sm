<?php
require_once '../../cmnvalidate.php';
$bydirect = true;
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
        // Get all Parent Post
        //$resulted_data = array();
        //$con = $this->connect();
        /*$query ="SELECT p.title
        FROM posts c
        INNER JOIN posts p ON c.parent_id = p.parent_id
        WHERE c.posts = @p0
        AND p.posts <> @p0";
        echo $query;exit;
        $query_result = $con->query($query);
        while ($row = $query_result->fetch_assoc()) {
            //$row[$option] = $this->replaceUnwantedChars($row[$option], 2);
            $result = $row;
        }
        print_r($result);
                 exit;*/
                
        $resulted_data = $obj->createDropDownForParentChild('post_comments','status = 1 AND parent_id = 0','id','comment','Select Parent Post Comment','comment','ASC','','');
        //print_r($resulted_data);exit;
        //print_r($resulted_data);
        //createDropDownForParentChild('tbl_category', 'pid = 0', 'id', 'title', 'Select Category', 'title', 'ASC', '', $f_category)
        /*$query = "SELECT id,name FROM `post_types` WHERE status = '1' ";
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
echo $result;
?>