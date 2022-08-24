<?php
include 'DatabaseConfig.php';

if(isset($_POST['token'])){
    global $con;
    $access_token = $_POST['token'];
    if(isset($_POST['user_id'])){
        //logout user from particular device
        $userID = $_POST['user_id'];
        $query = "DELETE FROM `personal_access_tokens` WHERE user_id ='$userID'";
    }
    else{
        //logout user from particular device
        $query = "DELETE FROM `personal_access_tokens` WHERE token ='$access_token'";
    }
    $result = mysqli_query($con,$query);
    if($result){
        echo json_encode(
            [
                'success' => true,
                'message' => 'Logout Successful'
            ]
        );
    }else{
        echo json_encode(
            [
                'success' => false,
                'message' => 'Logout Failed'
            ]
        );
    }
}else{
    echo json_encode(
        [
            'success' => false,
            'message' => 'token is required'
        ]
    );
}
?>