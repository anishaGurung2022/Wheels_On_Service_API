<?php

include 'DatabaseConfig.php';

if(isset($_POST['token'])){
    $token = $_POST['token'];
    checkServiceCenterID($token);
}
else{
    echo json_encode(
        [
            'success' => true,
            'message' => "token not found"
        ]
        );
};





function checkServiceCenterID($token)
{
        global $con;
        $check_token = "SELECT * FROM `access_tokens` WHERE token = '$token'";
        $result = mysqli_query($con, $check_token);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $serviceCenterID = mysqli_fetch_assoc($result)['serviceCenter_id'];
            //return $serviceCenterID;
            echo json_encode(
                [
                    'success' => true,
                    'id' => $serviceCenterID
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => true,
                    'message' => "Error"
                ]
            );
        }
}
?>