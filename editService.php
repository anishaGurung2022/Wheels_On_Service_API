<?php
include 'DatabaseConfig.php';
global $conn;

if (isset($_POST['id'])&& isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_FILES["image"])) {
        $id=$_POST['id'];
        $name=$_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        
        //getimage
        if(isset($_FILES['image'])){
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_ext = pathinfo($image, PATHINFO_EXTENSION);
            $image_path = "images/".$image;
    
            //upload image
            if ($image_size < 5000000) {
                if ($image_ext == "jpg" || $image_ext == "png" || $image_ext == "jpeg") {
                    if (move_uploaded_file($image_tmp, $image_path)) {
                        //inserting data into database
                        $sql = "UPDATE `services` SET `name`='$name',`description`='$description',`price`='$price',`image`='$image_path' WHERE id = '$id'";
                        $query = mysqli_query($con, $sql);
                        if ($query) {
                            $data=['success'=>true, 'message'=>'Service updated successfully.'];
                            echo json_encode($data);
                        } else {
                            $data=['success'=>false, 'message'=>'Something went wrong.'];
                            echo json_encode($data);
                        }
                    } else {
                        $data=['success'=>false, 'message'=>'Something went wrong.'];
                        echo json_encode($data);
                    }
                } else {
                    $data=['success'=>false, 'message'=>'Image must be jpg, png or jpeg.'];
                    echo json_encode($data);
                }
            } else {
                $data=['success'=>false, 'message'=>'Image size must be less than 5MB.'];
                echo json_encode($data);
            }
        }else{
            $sql = "UPDATE `services` SET `name`='$name',`description`='$description',`price`='$price' WHERE id = '$id'";
            $query = mysqli_query($con, $sql);
            if ($query) {
                $data=['success'=>true, 'message'=>'Service updated successfully.'];
                echo json_encode($data);
            } else {
                $data=['success'=>false, 'message'=>'Something went wrong.'];
                echo json_encode($data);
            }

        }

    }else{
        $data=['success'=>false, 'message'=>'Id,Service name and image is required.'];
        echo json_encode($data);
    }