<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if($isAdmin){
    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['category_id']) && isset($_FILES['image'])){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];

        //get image
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $image_path = "images/".$image;

        if($image_size < 5000000){
            if($image_ext == "jpg" || $image_ext == "png" || $image_ext == "jpeg"){
                if(move_uploaded_file($image_tmp,$image_path)){
                    $add_service = " INSERT INTO `services`(`name`, `description`, `price`, `category_id`, `image`) VALUES ('$name','$description','$price','$category_id','$image_path')";
                    $result = mysqli_query($con,$add_service);
                    if($result){
                        echo json_encode(
                            [
                                'success' => true,
                                'message' => "Service Added Successful"
                            ]
                        );
                    }else{
                        echo json_encode(
                            [
                                'success' => false,
                                'message' => "Error Adding Service"
                            ]
                        );
                    }
                }
                else{
                    echo json_encode(
                        [
                            'success' => false,
                            'message' => "Error Loading Image"
                        ]
                    );
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