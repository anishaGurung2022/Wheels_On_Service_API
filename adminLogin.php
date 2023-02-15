<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;

header("Access-Control-Allow-Origin: *");

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(strpos($email,"@gmail.com")){
        //check if the email is already in the database
        $check_email = "SELECT * FROM `customers` WHERE email = '$email'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data=mysqli_fetch_assoc($result);
            $customerID = $data['id'];
            if($customerID!=null){
                global $con;
                $check_admin = "SELECT * FROM `customers` WHERE id = '$customerID'";
                $result = mysqli_query($con,$check_admin);
                $count = mysqli_num_rows($result);
                if($count > 0){
                    $details = mysqli_fetch_assoc($result);
                    $customerID =  $details['id'];
                    $databasePassword= $details['password'];
                    if($details['isAdmin'] == 1){
                        login($password,$databasePassword,$customerID);
                    }else{
                        echo json_encode(
                            [
                                'success' => false,
                                'message' => 'Admin not found.'
                            ]
                        );
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
          
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


