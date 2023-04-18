<?php

include 'DatabaseConfig.php';
include 'helper_functions/serviceCenter_authentication_functions.php';

global $con;
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $serviceCenter_ID = checkIdValidUser($token);
    //get service centers from the database
    if($serviceCenter_ID != null){
        $services = "SELECT services.id, services.name, services.description, services.price, services.serviceCenter_id, categories.name as category, services.image FROM services JOIN categories ON services.category_id = categories.id where serviceCenter_id = $serviceCenter_ID";
        $result = mysqli_query($con, $services);
        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row != null){
                    $data[] = $row;
                }else{
                    echo json_encode(
                        [
                            'success' => false,
                            'message' => 'Services not found'
                        ]
                    );
                }
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
                'success' => false,
                'message' => "This Service Center is not found"
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