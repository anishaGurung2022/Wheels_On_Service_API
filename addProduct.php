<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if($isAdmin){
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['categoryID'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $categoryID = $_POST['categoryID'];

        $add_products = "INSERT INTO `products`(`name`, `price`, `description`,`category_id`) VALUES ('$name','$price','$description','$categoryID')";
        // $add_products = "INSERT INTO `products`(`name`, `price`, `description`,`category_id`) VALUES ('$name','$price','$description','$categoryID');";
        $result = mysqli_query($con,$add_products);
        if($result){
            echo json_encode(
                [
                    'success' => true,
                    'message' => "Product Added"
                ]
            );
        }else{
            echo json_encode(
                [
                    'success' => false,
                    'message' => "Error Adding Product"
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