<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

// Get the request body
$request_body = file_get_contents('php://input');
$request_data = json_decode($request_body, true);

// Check if the token is valid
$tokenCheck = checkIdValidUser($request_data['token'] ?? null);

if (isset($request_data['token']) && $tokenCheck != null && isset($request_data['booking_date']) && isset($request_data['total'])) {

    //get booking from the request
    $booking_details = $request_data['booking_details'];

    $total = $request_data['total'];
    $booking_date = date('Y-m-d H:i:s', strtotime($request_data['booking_date']));
    if (isset($request_data['token']) && $tokenCheck != null && isset($request_data['booking_date']) && isset($request_data['total'])) {
        //get booking from the request
        $booking_details = $request_data['booking_details'];
        $total = $request_data['total'];
        $booking_date = date('Y-m-d H:i:s', strtotime($request_data['booking_date']));
        $booking_id = null;
        foreach ($booking_details as $booking_detail) {
            $service = $booking_detail;
            $serviceCenterName =  $service['serviceCenter'];
            $serviceCenter_id = serviceCenterID($serviceCenterName);
            //insert into bookings table
            $sql = "INSERT INTO `bookings`(`customer_id`, `serviceCenter_id`, `status_`, `booking_date`, `total`) VALUES ('$tokenCheck','$serviceCenter_id','OnProcess','$booking_date','$total')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                //get the row id
                $booking_id = mysqli_insert_id($con);
                $service_ids = array();
                foreach ($booking_details as $booking_detail) {
                    $service = $booking_detail;
                    $service_id = $service['services_id'];
                    $service_ids[] = $service_id;
                    $sql = "INSERT INTO `booking_details`(`booking_id`, `service_id`) VALUES ('$booking_id','$service_id')";
                    $result = mysqli_query($con, $sql);
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Error adding booking',
                ];
                echo json_encode($data);
                exit; // exit the script if there was an error
            }
        }
        // create a single response object containing all necessary data
        $data = [
            'success' => true,
            'message' => 'Booking added successfully',
            'booking_id' => $booking_id,
            'service_ids' => $service_ids
        ];
        echo json_encode($data);
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Access denied'
            ]
        );
    }
}    

//     foreach ($booking_details as $booking_detail) {
//         $service = $booking_detail;
//         $serviceCenterName =  $service['serviceCenter'];
//         $serviceCenter_id = serviceCenterID($serviceCenterName);
//         //insert into bookings table
//         $sql = "INSERT INTO `bookings`(`customer_id`, `serviceCenter_id`, `status_`, `booking_date`, `total`) VALUES ('$tokenCheck','$serviceCenter_id','OnProcess','$booking_date','$total')";
//         $result = mysqli_query($con, $sql);
//         if ($result) {
//             //get the row id
//             $booking_id = mysqli_insert_id($con);
//             foreach ($booking_details as $booking_detail) {
//                 $service = $booking_detail;
//                 $service_id = $service['services_id'];

//                 $sql = "INSERT INTO `booking_details`(`booking_id`, `service_id`) VALUES ('$booking_id','$service_id')";
//                 $result = mysqli_query($con, $sql);
//             }
//             $data= [
//                 'success' => true,
//                 'message' => 'Booking added successfully',
//                 'booking_id' => $booking_id
//             ];
//             echo json_encode($data);
//         } else {
//             $data = [
//                 'success' => false,
//                 'message' => 'Error adding booking',
//             ];
//             echo json_encode($data);
//         }
//     }
// } else {
//     echo json_encode(
//         [
//             'success' => false,
//             'message' => 'Access denied'
//         ]
//     );
// }
