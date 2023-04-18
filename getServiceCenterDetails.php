<?php

include 'DatabaseConfig.php';
include 'helper_functions/serviceCenter_authentication_functions.php';

global $con;
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $serviceCenter_ID = checkIdValidUser($token);
    if($serviceCenter_ID != null){
        //get service centers from the database
        $details = "SELECT * FROM `servicecenters` WHERE id = $serviceCenter_ID";
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
                    'message' => 'Service Center details fetched Successfully'
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