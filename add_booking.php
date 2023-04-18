<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$tokenCheck = checkIdValidUser($_POST['token'] ?? null);
if (isset($_POST['token']) && $tokenCheck != null && isset($_POST['booking_date']) && isset($_POST['total'])  ) {

    //get booking from the request
    $booking_details = json_decode($_POST['booking_details']);
    
    $total = $_POST['total'];
    $booking_date = $_POST['booking_date'];

    foreach ($booking_details as $booking_detail) {
        $service = json_decode($booking_detail);
        $serviceCenterName =  $service-> serviceCenter;
        $serviceCenter_id = serviceCenterID($serviceCenterName);

        //insert into bookings table
        $sql = "INSERT INTO `bookings`(`customer_id`, `serviceCenter_id`, `status_`, `booking_date`, `total`) VALUES ('$tokenCheck','$serviceCenter_id','OnProcess','$booking_date','$total')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            //get the row id
            $booking_id = mysqli_insert_id($con);
            foreach ($booking_details as $booking_detail) {
                $service = json_decode($booking_detail);
                $service_id = $service-> id;

                $sql = "INSERT INTO `booking_details`(`booking_id`, `service_id`) VALUES ('$booking_id','$service_id')";
                $result = mysqli_query($con, $sql);
            }
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'Booking added successfully',
                    'booking_id' => $booking_id
                ]
            );
    } else {
        $data = [
            'success' => false,
            'message' => 'Error adding booking',
        ];
        echo json_encode($data);
    }
}
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Access denied'
        ]
    );
}