<?php
include 'DatabaseConfig.php';

global $con;

if(isset($_POST['id'])){
    $serviceID = $_POST['id']; 

    $sql = "UPDATE `services` SET `active_status`= 1 WHERE id = '$serviceID'";
    $query = mysqli_query($con, $sql);

    if ($query) {
        $data=['success'=>true, 'message'=>'Active Status On'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>'Active Status is still Off'];
        echo json_encode($data);
    }
}else{
    $data=['success'=>false, 'message'=>'ServiceID is required.'];
        echo json_encode($data);
}

?>
