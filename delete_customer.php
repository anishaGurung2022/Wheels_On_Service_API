<?php
include 'DatabaseConfig.php';
global $con;
if (isset($_POST['id']))
{
    $id = $_POST['id'];
    $sql = "DELETE FROM `customers` WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Customer deleted'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>'Something went wrong.'];
        echo json_encode($data);
                        }


}else{
    $data=['success'=>false, 'message'=>'Id required.'];
    echo json_encode($data);
}