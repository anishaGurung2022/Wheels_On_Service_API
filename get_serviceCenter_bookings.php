<?php
include 'DatabaseConfig.php';
include 'helper_functions/serviceCenter_authentication_functions.php';

if(isset($_POST['token'])){
    $token = $_POST['token'];
    $serviceCenter_ID = checkIdValidUser($token);
    //get service centers bookings from the database
    if($serviceCenter_ID != null){
        $bookings = "SELECT bookings.id, customers.name as customer, bookings.booking_date, bookings.status_, bookings.is_paid FROM bookings JOIN customers ON bookings.customer_id = customers.id where serviceCenter_id = '$serviceCenter_ID'";
        $result = mysqli_query($con, $bookings);
        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row != null){
                    $data[] = $row;
                }else{
                    echo json_encode(
                        [
                            'success' => false,
                            'message' => 'Bookings not found'
                        ]
                    );
                }
            }
            echo json_encode(
                [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Bookings fetched Successfully'
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
    }
}else{
    echo json_encode(
        [
            'success' => false,
            'message' =>'Access denied'
        ]
    );
}
?>