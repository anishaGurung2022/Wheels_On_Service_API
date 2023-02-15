<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

//get categories from the database
 $cities = "SELECT * FROM `cities`";
    $result = mysqli_query($con, $cities);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Cities fetched Successfully'
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