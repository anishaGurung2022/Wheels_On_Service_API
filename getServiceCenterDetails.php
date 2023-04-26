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
            //$image = mysqli_fetch_assoc($result)['image'];
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['image'] != null){
                    $data[] = $row;
                }
                else{
                    $row['image'] = "images\user_profile.jpg"; // set the default image file name or path here
                    $data[] = $row;
                }
            }
            echo json_encode(
                [
                    'success' => true,
                    //'image' => $image,
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