<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;

//get service centers from the database
 $serviceCenter = "SELECT * FROM `servicecenters`";
    $result = mysqli_query($con, $serviceCenter);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Service center fetched Successfully'
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