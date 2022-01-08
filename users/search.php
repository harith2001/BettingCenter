<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";


if(isset($_GET['id'])){

    $id = $_GET['id'];

    //create query
    $query = "SELECT firstName, lastName, userName FROM user WHERE id= :id AND isActive = 1 ";

    //prepare the query
    $stmt = $conn->prepare($query);

    //execute the query
    $stmt->execute(['id'=>$id]);

    if($stmt->rowCount() > 0) {

        $users_arr = array();
        $users_arr["data"] = array(); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
        $user_record = array(
            "id" => $id,
            "firstName" =>$firstName,
            "lastName" =>$lastName,
            "userName" =>$userName
        );

        array_push($users_arr["data"], $user_record);
        $users_arr["Success"] = true; 

        echo json_encode($users_arr);

    } else{

        $users_arr["Success"] = false; 
        echo json_encode($users_arr);
    }

    $stmt->closeCursor();

}

