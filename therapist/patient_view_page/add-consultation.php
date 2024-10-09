<?php

session_start();
include_once "../../conf.php";
    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    //check if the user is allowed to view this page
    if ($_SESSION['user_type'] != 2) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "<p>You are not authorized to access this page.</p>";

        exit();
    }   



    #create the query
    $sql = "INSERT INTO Sessions (patient_id, therapist_id, session_length, session_date)
            VALUES 
            (?,?,?, '".date("Y-m-d")."')" ;
    $statement =  mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 
    $patient_id = htmlspecialchars($_POST["patient_id"]);
    $session_length = htmlspecialchars($_POST["session_length"]);

    mysqli_stmt_bind_param($statement, 'iii', $patient_id,
                                                $_SESSION['id'],
                                                $session_length
                                                ); 

    $success = mysqli_stmt_execute($statement);


    

    #redirect based on success
    if($success){
        header("location: patient_view_page.php?id=".$patient_id."&notification=true&success=true&message=updated sucessfully"); 
    }
    else{
        header("location: patient_view_page.php?id=".$patient_id."&notification=true&success=false&message=".mysqli_error($conn)); 
    }
?>