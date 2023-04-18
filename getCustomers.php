<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
global $con;

//get customers from the database
 $customers = "SELECT * FROM `customers`";
    $result = mysqli_query($con, $customers);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row != null){
                $data[] = $row;
            }else{
                echo json_encode(
                    [
                        'success' => true,
                        'message' => 'customers not found'
                    ]
                );
            }
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'customers fetched Successfully'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching customers'
            ]
        );
    }