<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

if(isset($_POST['token'])){
    $token = $_POST['token'];
       //get bookings from bookings table
       $isAdmin = checkIfAdmin($token);
       if($isAdmin){
           $sql = "SELECT * FROM `bookings`";
       }else{
            $customerId=checkCustomerID($token);
            $sql = "SELECT * FROM `bookings` WHERE customer_id ='$customerId'";
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
                    'message' => "Orders fetched successfully"
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Error fetching orders'
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