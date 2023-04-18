<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $customer_ID = checkCustomerID($token);
    //get service centers from the database
    $details = "SELECT * FROM `customers` WHERE id = $customer_ID";
    $result = mysqli_query($con, $details);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Customer details fetched Successfully'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error'
            ]
        );
    }
}
else{
    echo json_encode(
        [
            'success' => true,
            'message' => "token not found"
        ]
        );
};

function checkCustomerID($token)
{
    global $con;
    $check_token = "SELECT * FROM `personal_access_tokens` WHERE token = '$token'";
    $result = mysqli_query($con, $check_token);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $customerID = mysqli_fetch_assoc($result)['customer_id'];
        return $customerID;
    } else {
        echo json_encode(
            [
                'success' => true,
                'message' => "Error"
            ]
        );
    }
}