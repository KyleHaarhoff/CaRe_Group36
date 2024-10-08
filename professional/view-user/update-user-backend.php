<?php
#Access control
session_start();
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 3) {
    http_response_code(403);
    echo "<h1>403 Forbidden</h1>";
    echo "<p>You are not authorized to access this page.</p>";

    exit();
}
#check all the post variables
if (isset($_POST["first_name"])&&
    isset($_POST["last_name"])&&
    isset($_POST["email"])&&
    isset($_POST["phone_number"])&&
    isset($_POST["age"])&&
    isset($_POST["user_id"])) { 
    require_once "../../common/db/db-conn.php"; 
    #create the query
    $sql = "UPDATE Users SET first_name = ?, last_name = ?, age = ?, gender=?, email=?, phone_number=? WHERE id = ?;" ;
    $statement =  mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 

    $first_name = htmlspecialchars($_POST["first_name"]);
    $last_name = htmlspecialchars($_POST["last_name"]);
    $age = htmlspecialchars($_POST["age"]);
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : "";
    $gender = htmlspecialchars($gender);
    $email = htmlspecialchars($_POST["email"]);
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    $user_id = htmlspecialchars($_POST["user_id"]);

    mysqli_stmt_bind_param($statement, 'ssisssi', $first_name,
                                                $last_name,
                                                $age,
                                                $gender,
                                                $email,
                                                $phone_number,
                                                $user_id); 

    $success = mysqli_stmt_execute($statement);


    

    #redirect based on success
    if($success){
        header("location: ../home/home.php?notification=true&success=true&message=Updated user sucessfully"); 
    }
    else{
        header("location: ../home/home.php?notification=true&success=false&message=".mysqli_error($conn)); 
    }
    mysqli_close($conn);
    exit; 
} 


http_response_code(400);
// Display an error message
echo "<h1>400 Bad Request</h1>";
echo "<p>The request did not contain all the required information.</p>";
?>