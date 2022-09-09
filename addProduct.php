<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if($isAdmin){
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_FILES['image']) && isset($_POST['categoryID'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $categoryID = $_POST['categoryID'];
        
        //get image
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $image_path = "images/".$image;

        //upload image
        if($image_size < 5000000){
            if($image_ext == "jpg" || $image_ext == "png" || $image_ext == "jpeg"){
                if(move_uploaded_file($image_tmp,$image_path)){
                    $add_products = "INSERT INTO `products`(`name`, `price`, `description`, `image`, `category_id`) VALUES ('$name','$price','$description','$image_path','$categoryID')";
                    $result = mysqli_query($con,$add_products);
                    if($result){
                        echo json_encode(
                            [
                                'success' => true,
                                'message' => "Product Added Successful"
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

                }
            }else{
                echo json_encode(
                    [
                        'success' => false,
                        'message' => 'Image must be jpg, png or jpeg.'
                    ]
                );
            }
        }else{
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Image size must be less that 5MB'
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