<?php
require_once '../../cmnvalidate.php';
require_once '../../libs/image/ImageManipulator.php';
if (isset($_SESSION['user']) && $_SESSION['user']['userRole'] == "admin"){ 
        /*if(isset($_REQUEST['speadmin']) && $_REQUEST['speadmin'] == 1){  
         if (isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['email'])){
               $validation_flag = 0;
               $validation_error_code = NULL;
               //$spe_id = $_REQUEST['speid'];
               $first_name = $_REQUEST['firstname'];
               $last_name = $_REQUEST['lastname'];
               $email = $_REQUEST['email'];
               $secretkey = substr(sha1(mt_rand()), 0, 22);  
               $password = $obj->encryptIt($secretkey);
               $gender = $_REQUEST['gender']; 
               $dob = date('Y-m-d',  strtotime($_REQUEST['dob']));
               $status = 1;  
               $role_id = 1;
               $profilepic = "image_not_available.png";
               
               if(isset($_FILES['profile_image'])){ 
                      $file_name = time().$_FILES['profile_image']['name'];
                      $file_size =$_FILES['profile_image']['size'];
                      $file_tmp =$_FILES['profile_image']['tmp_name'];
                      $file_type=$_FILES['profile_image']['type'];                    
                      $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));   
                      if ( !in_array($ext, array('jpg','jpeg','png','gif','bmp')) ) {
                          $response = 'Invalid file extension.';
                          $validation_flag = 1;
                          $validation_error_code = 'Invalid file extension';
                      } else {
                           $manipulator = new ImageManipulator($_FILES['profile_image']['tmp_name']);
                           $newImage = $manipulator->resample(400, 400);
                           $res = $manipulator->save(PROJECT_ROOT_UPLOAD."/users/".$file_name);
                           $profilepic = $file_name;
                      }
               }

               if (empty($_REQUEST['firstname'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'FirstName is required';
               }  else if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
                   $validation_flag = 1;
                   $validation_error_code = 'FirstName is Invalid';
               } else if (empty($_REQUEST['lastname'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'LastName is required';
               } else if (!preg_match("/^[a-zA-Z]*$/", $_REQUEST['lastname'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'LastName is Invalid';
               } else if (empty($_REQUEST['email'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'Email is required';
               } else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                   $validation_flag = 1;
                   $validation_error_code = 'Email is Invalid';
               } 

               if ($validation_flag == 0) {
                   $query = "SELECT `id` FROM `users` WHERE `email` = '$email'";
                   $query_result = $con->query($query);
                   if ($query_result->num_rows == 0) {
                               $query = "INSERT INTO `users` (role_id, spe_id, email, password, firstname, lastname, profile_image, gender, dob, status) VALUES ('$role_id','$spe_id','$email', '$password', '$first_name', '$last_name', '$profilepic', '$gender', '$dob', '$status')";
                               $query_result = $con->query($query);
                               if($query_result){
                                   $result['success'] = 1;
                                   $result['data'] = 'success';
                                   $result['error'] = 0;
                                   $result['error_code'] = NULL;
                                   
                                   // Send email
                                   $name = $first_name." ".$last_name;
                                   $content =  file_get_contents(SITE_ROOT.'/tpl/email/welcomespe.html'); 
                                   $content = str_replace('{{name}}', $name, $content);
                                   $content = str_replace('{{siteurl}}', SITE_ROOT, $content);
                                   $content = str_replace('{{email}}', $email, $content);
                                   $content = str_replace('{{password}}', $password, $content);
                                   $sendemail = $obj->SendEmail($obj->from_admin_email,$obj->from_admin_name,$email,$name,'Welcome to FitFinder',$content,null);
                                   if($sendemail == "success"){
                                        $result['email_sent'] = 1;
                                   } else {
                                        $result['email_sent'] = 0;
                                   }
                               } else {
                                   $result['success'] = 0;
                                   $result['data'] = NULL;
                                   $result['error'] = 1;
                                   $result['error_code'] = "Error in query";
                               }
                   } else {
                       $result['success'] = 0;
                       $result['data'] = NULL;
                       $result['error'] = 1;
                       $result['error_code'] = 'Email Already Registered';
                   }
               } else {
                   $result['success'] = 0;
                   $result['data'] = NULL;
                   $result['error'] = 1;
                   $result['error_code'] = $validation_error_code;
               }
           } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Required Parameter Are Missing';
           }
     }
     */
     if(isset($_REQUEST['adduser']) && $_REQUEST['adduser'] == 1){ 
         $created = $obj->getTimeZone('Y-m-d H:i:s');
         if (isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['email'])){
               $validation_flag = 0;
               $validation_error_code = NULL;
               $first_name = $_REQUEST['firstname'];
               $last_name = $_REQUEST['lastname'];
               $email = $_REQUEST['email'];
               $secretkey = substr(sha1(mt_rand()), 0, 22);  
               $password = $obj->encryptIt($secretkey);
               $gender = $_REQUEST['gender']; 
               $dob = date('Y-m-d',  strtotime($_REQUEST['dob']));
               $phone = $_REQUEST['phone']; 
               //$aboutus = $obj->replaceUnwantedChars($_REQUEST['aboutus'],1); 
               //$timezone = $_REQUEST['timezone']; 
               //$address = $obj->replaceUnwantedChars($_REQUEST['address'],1); 
               //$city = $obj->replaceUnwantedChars($_REQUEST['city'],1); 
               //$state = $obj->replaceUnwantedChars($_REQUEST['state'],1); 
               //$country = $obj->replaceUnwantedChars($_REQUEST['country'],1); 
               //$zipcode = $_REQUEST['zipcode']; 
               //$latitude = $_REQUEST['latitude']; 
               //$longitude = $_REQUEST['longitude']; 
               $status = 1; 
               if (isset($_REQUEST['status'])){
                   $status = $_REQUEST['status'];
               }
               $role_id = 1;
               $profilepic = "image_not_available.png";
               if(isset($_FILES['profile_image'])){ 
                      $file_name = time().$_FILES['profile_image']['name'];
                      $file_size =$_FILES['profile_image']['size'];
                      $file_tmp =$_FILES['profile_image']['tmp_name'];
                      $file_type=$_FILES['profile_image']['type'];                    
                      $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));   
                      if ( !in_array($ext, array('jpg','jpeg','png','gif','bmp')) ) {
                          $response = 'Invalid file extension.';
                          $validation_flag = 1;
                          $validation_error_code = 'Invalid file extension';
                      } else {
                           $manipulator = new ImageManipulator($_FILES['profile_image']['tmp_name']);
                           $newImage = $manipulator->resample(400, 400);
                           $res = $manipulator->save(PROJECT_ROOT_UPLOAD."/users/".$file_name);
                           $profilepic = $file_name;
                      }
               }
               
               /*$profile_cover = "no-cover-image.png";
               if(isset($_FILES['profile_cover'])){ 
                      $file_name = time().$_FILES['profile_cover']['name'];
                      $file_size =$_FILES['profile_cover']['size'];
                      $file_tmp =$_FILES['profile_cover']['tmp_name'];
                      $file_type=$_FILES['profile_cover']['type'];                    
                      $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));   
                      if ( !in_array($ext, array('jpg','jpeg','png','gif','bmp')) ) {
                          $response = 'Invalid file extension.';
                          $validation_flag = 1;
                          $validation_error_code = 'Invalid file extension';
                      } else {
                           $manipulator = new ImageManipulator($_FILES['profile_cover']['tmp_name']);
                           $newImage = $manipulator->resample(1200, 700);
                           $res = $manipulator->save(PROJECT_ROOT_UPLOAD."/users/cover/".$file_name);
                           $profile_cover = $file_name;
                      }
               }*/

               if (empty($_REQUEST['firstname']) ) {
                   $validation_flag = 1;
                   $validation_error_code = 'FirstName is required';
               }  else if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
                   $validation_flag = 1;
                   $validation_error_code = 'FirstName is Invalid';
               } else if (empty($_REQUEST['lastname'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'LastName is required';
               } else if (!preg_match("/^[a-zA-Z]*$/", $_REQUEST['lastname'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'LastName is Invalid';
               } else if (empty($_REQUEST['email'])) {
                   $validation_flag = 1;
                   $validation_error_code = 'Email is required';
               } else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                   $validation_flag = 1;
                   $validation_error_code = 'Email is Invalid';
               } /*else if (!preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $latitude)) {
                    $validation_flag = 1;
                    $validation_error_code = 'Latitude is Invalid';
               } else if (!preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $longitude)) {
                    $validation_flag = 1;
                    $validation_error_code = 'Longitude is Invalid';
               } */
               if ($gender == 'male'){
                   $gender = 1;
               }else if ($gender == 'female'){
                   $gender = 2;
               }
               if ($validation_flag == 0) {
                   $query = "SELECT `id` FROM `users` WHERE `email` = '$email'";
                   $query_result = $con->query($query);
                   if ($query_result->num_rows == 0) {
                               $query = "INSERT INTO `users` (role, email, password, first_name, last_name, profile_img, gender, dob, mobile_number, status,created) 
                                        VALUES ('$role_id','$email', '$password', '$first_name', '$last_name', '$profilepic', '$gender', '$dob','$phone','$status','$created')";
                               
                               $query_result = $con->query($query);
                               if($query_result){
                                   //$spiid = $con->insert_id;
                                   /*if(!empty($_REQUEST['specialities']) && !empty($spiid)){
                                         $specialities = $_REQUEST['specialities'];
                                         foreach($specialities as $key=>$value){
                                               $id = $value;
                                               $query = "INSERT INTO users_specialities(`user_id`,`spec_id`,`status`) VALUES ('$spiid','$value','1')";
                                               $query_result = $con->query($query);
                                         }
                                   }*/
                                   /*if(!empty($_REQUEST['educations']) && !empty($spiid)){
                                         $educations = $_REQUEST['educations'];
                                         foreach($educations as $key=>$value){
                                               $coursename = $value['coursename'];
                                               $universityname = $value['universityname'];
                                               $startyear = $value['startyear'];
                                               $endyear = $value['endyear'];
                                               $query = "INSERT INTO users_education(`user_id`,`coursename`,universityname,startyear,endyear,`status`) VALUES ('$spiid','$coursename','$universityname','$startyear','$endyear','1')";
                                               $query_result = $con->query($query);
                                         }
                                   }*/
                                   $result['success'] = 1;
                                   $result['data'] = 'success';
                                   $result['error'] = 0;
                                   $result['error_code'] = NULL;
                                   
                                   // Send email
                                   /*$name = $first_name." ".$last_name;
                                   $content =  file_get_contents(SITE_ROOT.'/tpl/email/welcomespe.html'); 
                                   $content = str_replace('{{name}}', $name, $content);
                                   $content = str_replace('{{siteurl}}', SITE_ROOT, $content);
                                   $content = str_replace('{{email}}', $email, $content);
                                   $content = str_replace('{{password}}', $password, $content);
                                   $sendemail = $obj->SendEmail($obj->from_admin_email,$obj->from_admin_name,$email,$name,'Welcome to FitFinder',$content,null);
                                   if($sendemail == "success"){
                                        $result['email_sent'] = 1;
                                   } else {
                                        $result['email_sent'] = 0;
                                   }*/
                               } else {
                                   $result['success'] = 0;
                                   $result['data'] = NULL;
                                   $result['error'] = 1;
                                   $result['error_code'] = "Error in query";
                               }
                   } else {
                       $result['success'] = 0;
                       $result['data'] = NULL;
                       $result['error'] = 1;
                       $result['error_code'] = 'Email Already Registered';
                   }
               } else {
                   $result['success'] = 0;
                   $result['data'] = NULL;
                   $result['error'] = 1;
                   $result['error_code'] = $validation_error_code;
               }
           } else {
               $result['success'] = 0;
               $result['data'] = NULL;
               $result['error'] = 1;
               $result['error_code'] = 'Required Parameter Are Missing';
           }
     }
$result = json_encode($result);
echo $result;
}
?>