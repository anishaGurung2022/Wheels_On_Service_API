<?php
include 'DatabaseConfig.php';
global $con;
if (isset($_POST['id'])&& isset($_POST['name']) && isset($_POST['description']))
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $sql = "UPDATE `categories` SET `name`='$name',`description`='$description' WHERE id = '$id'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data=['success'=>true, 'message'=>'Category updated successfully.'];
        echo json_encode($data);
    } else {
        $data=['success'=>false, 'message'=>'Something went wrong.'];
        echo json_encode($data);
                        }


}else{
    $data=['success'=>false, 'message'=>'Id, name and description is required.'];
    echo json_encode($data);
}