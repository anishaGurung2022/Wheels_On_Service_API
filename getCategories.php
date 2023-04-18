<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");


global $con;

//get categories from the database
 $categories = "SELECT * FROM `categories` ";
    $result = mysqli_query($con, $categories);
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
                'message' => 'Categories fetched Successfully'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching categories'
            ]
        );
    }