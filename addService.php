<?php
include 'DatabaseConfig.php';
include 'helper_functions/serviceCenter_authentication_functions.php';


if (isset($_POST['token']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['category_id']) && isset($_FILES["image"])) {
    $token = $_POST['token'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price= $_POST['price'];
    $category_id = $_POST['category_id'];
    $serviceCenter_id = checkIdValidUser($token);
    
     //getimage
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
              $sql = "INSERT INTO `services`(`name`, `description`, `price`, `category_id`, `serviceCenter_id`, `image`) VALUES ('$name','$description','$price','$category_id','$serviceCenter_id','$image_path')";
              //$sql = "INSERT INTO `services`(`name`, `description`, `price`, `category_id`, `image`) VALUES ('$name','$description','$price','$category_id','$image_path')";
              $query = mysqli_query($con, $sql);
              if ($query) {
                $data=['success'=>true, 
                    'message'=>'Service added successfully'];
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
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Please fill all the fields.'
        ]
    );
}

// $isServiceCenter = checkIdValidUser($_POST['token'] ?? null);
// if($isServiceCenter){
   
// }else{
//     echo json_encode(
//         [
//             'success' => false,
//             'message' => "Access Denied"
//         ]
//     );
// }



?>