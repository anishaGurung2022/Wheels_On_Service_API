<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

header("Access-Control-Allow-Origin: *");

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if($isAdmin){
    if (isset($_POST['name']) && isset($_POST['description'])){
        $name = $_POST['name'];
        $description = $_POST['description'];

        $add_category = "INSERT INTO `categories`(`name`, `description`) VALUES ('$name','$description')";
        $result = mysqli_query($con,$add_category);
        if($result){
            echo json_encode(
                [
                    'success' => true,
                    'message' => "Category Added"
                ]
            );
        }else{
            echo json_encode(
                [
                    'success' => false,
                    'message' => "Error Adding Category"
                ]
            );
        }
    }else{
        echo json_encode(
            [
                'success' => false,
                'message' => "Please fill fields properly"
            ]
        );
    }
}else{
    echo json_encode(
        [
            'success' => false,
            'message' => "Access Denied"
        ]
    );
}
?>