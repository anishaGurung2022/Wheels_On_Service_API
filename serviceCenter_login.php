<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions2.php';

global $con;

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(strpos($email,"@gmail.com")){
        //check if the email is already in the database
        $check_email = "SELECT * FROM `servicecenters` WHERE email = '$email'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data=mysqli_fetch_assoc($result);
            $databasePassword= $data['password'];
            $serviceCenterID = $data['id'];
            login($password,$databasePassword,$serviceCenterID);
          
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'User not found.'
                ]
            );
        }

    }
    else{
        echo json_encode(
            [
                'success' => false,
                'message' => 'Invalid email'
            ]
        );
    }
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Please fill all the fields.'
        ]
    );
}


