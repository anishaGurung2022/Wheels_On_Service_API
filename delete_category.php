<?php
include 'DatabaseConfig.php';
global $con;
if (isset($_POST['id']))
{
    $id = $_POST['id'];
    $sql = "DELETE FROM `categories` WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Category deleted'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>'Something went wrong.'];
        echo json_encode($data);
                        }


}else{
    $data=['success'=>false, 'message'=>'Id required.'];
    echo json_encode($data);
}