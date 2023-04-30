<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

global $con;
header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

// get services from the database
$services_query = "SELECT services.id, services.name, services.description, services.price, categories.name as category, servicecenters.name as serviceCenter, services.image FROM services JOIN categories ON services.category_id = categories.id JOIN servicecenters ON services.serviceCenter_id = servicecenters.id WHERE services.active_status = 1";
$result = mysqli_query($con, $services_query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $services_count_query = "SELECT COUNT(*) AS count FROM services";
    $count_result = mysqli_query($con, $services_count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $services_count = $count_row['count'];

    if (count($data) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $data,
            'count' => $services_count,
            'message' => 'Services fetched successfully'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'count' => $services_count,
            'message' => 'No services found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching services'
    ]);
}
