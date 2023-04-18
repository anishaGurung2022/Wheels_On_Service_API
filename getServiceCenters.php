<?php

global $con;
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

//get categories from the database
 $serviceCenters = "SELECT servicecenters.id, servicecenters.name, servicecenters.phone, servicecenters.address, servicecenters.email, servicecenters.userName, servicecenters.image, cities.name as cities FROM servicecenters join cities on servicecenters.city_id = cities.id;";
    $result = mysqli_query($con, $serviceCenters);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row != null){
                $data[] = $row;
            }else{
                echo json_encode(
                    [
                        'success' => true,
                        'message' => 'Service Centers not found.'
                    ]
                );
            }
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Service Centers fetched Successfully'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching Cities'
            ]
        );
    }