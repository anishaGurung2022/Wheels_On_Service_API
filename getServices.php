<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;
header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

//get servicess from the database
 $services = "SELECT services.id, services.name, services.description, services.price, categories.name as category, servicecenters.name as serviceCenter, services.image FROM services JOIN categories ON services.category_id = categories.id JOIN servicecenters ON services.serviceCenter_id = servicecenters.id";
    $result = mysqli_query($con, $services);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row != null){
                $data[] = $row;
            }else{
                echo json_encode(
                    [
                        'success' => true,
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
                'message' => 'Error fetching Services'
            ]
        );
    }