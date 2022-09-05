<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

//get product from the database
 $products = "SELECT * FROM products";
    $result = mysqli_query($con, $products);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Produts fetched'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching products'
            ]
        );
    }