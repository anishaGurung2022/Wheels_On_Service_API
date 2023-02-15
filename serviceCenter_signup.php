<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions2.php';

global $con;
if(isset($_POST['name']) && isset($_POST['phone']) && isset( $_POST['address'])&& isset( $_POST['city_id']) && isset( $_POST['email']) && isset($_POST['userName']) && isset($_POST['password'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city_id = $_POST['city_id'];
    $email = $_POST['email'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    //CHECK if email and phone number is valid
    if(strpos($email,"@gmail.com") !== false && preg_match('/^[0-9]{10}+$/', $phone)){

        //check if the email is already in the database
        $check_email = "SELECT * FROM `servicecenters` WHERE email = '$email'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Account already exists in this email!'
                ]
            );
        } else {
            //creating an account by calling signup function
            signup($name,$phone,$address,$city_id,$email,$userName,$password);
        }
    }
    else{
        echo json_encode(
            [
                'success' => false,
                'message' => 'Incorrect email and phone number.'
            ]
        );
    }
}
else{
    json_encode(
        [
            'success' => false,
            'message' => 'Please fill all the fields.'
        ]
    );
}


?>