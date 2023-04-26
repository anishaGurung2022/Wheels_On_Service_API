<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

// Get the request body
$request_body = file_get_contents('php://input');
$request_data = json_decode($request_body, true);


if (isset($request_data['token']) && isset($request_data['payment_date']) && isset($request_data['cost']) && isset($request_data['booking_id'])) {
    $token = $request_data['token'];
    $payment_date = date('Y-m-d', strtotime($request_data['payment_date']));
    $cost = $request_data['cost'];
    $booking_id = $request_data['booking_id'];
    $add_payment = "INSERT INTO `payment`(`token`, `cost`, `payment_date`, `booking_id`) VALUES ('$token','$cost','$payment_date','$booking_id')";
    $result = mysqli_query($con, $add_payment);
    if ($result) {
        $paymentStatus = "UPDATE `bookings` SET `is_paid`= 1 WHERE id = $booking_id";
        $result = mysqli_query($con, $paymentStatus);
        echo json_encode(
            [
                'success' => true,
                'message' => "Payment Added"
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => "Error Adding Payment"
            ]
        );
    }
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Access denied'
        ]
    );
}
