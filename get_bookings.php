<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

if(isset($_POST['token'])){
    $token = $_POST['token'];
       //get bookings from bookings table
       $isAdmin = checkIfAdmin($token);
       if($isAdmin){
           $sql = "SELECT b.id AS booking_id, 
           c.name AS customer_name, 
           sc.name AS service_center_name, 
           b.booking_date, b.total, b.is_paid,
           s.name AS service_name, s.price AS service_price
           FROM bookings b
           JOIN customers c ON b.customer_id = c.id
           JOIN servicecenters sc ON b.servicecenter_id = sc.id
           JOIN booking_details bd ON b.id = bd.booking_id
           JOIN services s ON bd.service_id = s.id;
           ";
       }else{
            $customerId =  checkIdValidUser($token);
            $sql = "SELECT bookings.id,  servicecenters.name as serviceCenter, bookings.booking_date, bookings.total, bookings.is_paid FROM bookings JOIN servicecenters ON bookings.serviceCenter_id = servicecenters.id WHERE customer_id ='$customerId'";
       }
        $result = mysqli_query($con, $sql);
        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode(
                [
                    'success' => true,
                    'data' => $data,
                    'message' => "Bookings fetched successfully"
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Error fetching Bookings'
                ]
            );
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