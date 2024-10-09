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
    $sql = "UPDATE `patient_therapist` set requires_followup = ?, note=?, case_type=? where patient_id = ? and therapist_id = ?;" ;
    $statement =  mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 

    $followup = htmlspecialchars($_POST["followup"]);
    if($followup){
        $followup = "Yes";
    }
    else{
        $followup = "No";

    }
    $note = htmlspecialchars($_POST["note"]);
    $case_type = htmlspecialchars($_POST["case_type"]);
    $patient_id = htmlspecialchars($_POST["patient_id"]);

    mysqli_stmt_bind_param($statement, 'sssii', $followup,
                                                $note,
                                                $case_type,
                                                $patient_id,
                                                $_SESSION['id']); 

    $success = mysqli_stmt_execute($statement);


    

    #redirect based on success
    if($success){
        header("location: patient_view_page.php?id=".$patient_id."&notification=true&success=true&message=updated sucessfully"); 
    }
    else{
        header("location: patient_view_page.php?id=".$patient_id."&notification=true&success=false&message=".mysqli_error($conn)); 
    }
?>