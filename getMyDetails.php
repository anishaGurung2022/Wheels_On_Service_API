<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
    
    //checking the valid token
    $tokenCheck = checkIdValidUser($_GET['token']??null);
    if(isset($_GET['token']) && $tokenCheck != null){

        $userID = $tokenCheck;
        $getUserDetails= "SELECT * FROM users WHERE id = '$userID'";
        $result = mysqli_query($con,$getUserDetails);
        $data=mysqli_fetch_assoc($result);
        echo json_encode(
            [
                'success' => true,
                'message' => 'User found',
                'data' => $data
            ]
        );

    }
    else{
        echo json_encode(
            [
                'success' => false,
                'message' =>'Access denied'
            ]
        );
    }


   
?>
