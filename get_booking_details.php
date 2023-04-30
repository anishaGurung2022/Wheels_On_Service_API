<?php

include 'DatabaseConfig.php';

global $con;

if(isset($_POST['id'])){
    $bookingID = $_POST['id']; 
    $bookingDetails = "SELECT 
    se.name as service_name, 
    se.price as service_price,
    b.status_
FROM 
    bookings b 
    JOIN booking_details bd ON b.id = bd.booking_id 
    JOIN services se ON bd.service_id = se.id 
WHERE 
    b.id = '$bookingID'";
$result = mysqli_query($con, $bookingDetails);
if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(
        [
            'success' => true,
            'data' => $data,
            'message' => "Booking Details fetched successfully"
        ]
    );
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Error fetching Booking Details'
        ]
    );
}
    
}else{
    
}

?>
