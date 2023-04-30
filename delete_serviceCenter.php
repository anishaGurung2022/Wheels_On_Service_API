<?php
include 'DatabaseConfig.php';
global $con;
if (isset($_POST['id']))
{
    $id = $_POST['id'];
    $sql = "SELECT * FROM `servicecenters` WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Service Centers deleted'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>'Something went wrong.'];
        echo json_encode($data);
                        }

}else{
    $data=['success'=>false, 'message'=>'Id required.'];
    echo json_encode($data);
}