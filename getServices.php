<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $serviceCenter_ID = checkServiceCenterID($token);
    //get service centers from the database
    $services = "SELECT * FROM `services` WHERE serviceCenter_id = $serviceCenter_ID";
    $result = mysqli_query($con, $services);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Services fetched Successfully'
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

function checkServiceCenterID($token)
{
        global $con;
        $check_token = "SELECT * FROM `access_tokens` WHERE token = '$token'";
        $result = mysqli_query($con, $check_token);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $serviceCenterID = mysqli_fetch_assoc($result)['serviceCenter_id'];
            return $serviceCenterID;
        } else {
            echo json_encode(
                [
                    'success' => true,
                    'message' => "Error"
                ]
            );
        }
}