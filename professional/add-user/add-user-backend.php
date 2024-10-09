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
    isset($_POST["user_type"])&&
    isset($_POST["age"])) { 
    require_once "../../common/db/db-conn.php"; 
    #create the query
    $sql = "INSERT INTO Users(first_name, last_name, age, gender, email, phone_number, password, user_type) 
    VALUES(?, ?, ?, ?, ?, ?, SHA1('password'), ?);" ;
    $statement =  mysqli_stmt_init($conn);

    mysqli_stmt_prepare($statement, $sql); 

    $first_name = htmlspecialchars($_POST["first_name"]);
    $last_name = htmlspecialchars($_POST["last_name"]);
    $age = htmlspecialchars($_POST["age"]);
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : "";
    $gender = htmlspecialchars($gender);
    $email = htmlspecialchars($_POST["email"]);
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    $user_type = htmlspecialchars($_POST["user_type"]);

    mysqli_stmt_bind_param($statement, 'ssisssi', $first_name,
                                                $last_name,
                                                $age,
                                                $gender,
                                                $email,
                                                $phone_number,
                                                $user_type); 

    $success = mysqli_stmt_execute($statement);


    

    #redirect based on success
    if($success){
        $last_id = $conn->insert_id;
        if($user_type == 1){
            $sql = "INSERT INTO Affirmations(patient_id) VALUES (?);";
            $statement =  mysqli_stmt_init($conn);

            mysqli_stmt_prepare($statement, $sql); 
            mysqli_stmt_bind_param($statement, 'i', $last_id);
            $success = mysqli_stmt_execute($statement);
        }


        #if it is a patient and there is a therapist
        if (isset($_POST["therapist"])&& $user_type == 1){
            $sql = "INSERT INTO patient_therapist (patient_id, therapist_id, assigned_on, journal_status, requires_followup, created_on)
                    VALUES
                    (?, ?, '".date("Y-m-d")."', 'Up to date', 'No', '".date("Y-m-d")."')" ;
            if(isset($_POST['notes'])){
                
                $sql = "INSERT INTO patient_therapist (patient_id, therapist_id, note, assigned_on, journal_status, requires_followup, created_on)
                VALUES
                    (?, ?, ?, '".date("Y-m-d")."', 'Up to date', 'No', '".date("Y-m-d")."')" ;
            }
            $statement =  mysqli_stmt_init($conn);

            mysqli_stmt_prepare($statement, $sql); 

            $therapist_id = htmlspecialchars($_POST["therapist"]);
            
            if(isset($_POST['notes'])){
                $note = htmlspecialchars($_POST["notes"]);
                mysqli_stmt_bind_param($statement, 'iis', $last_id,
                                                            $therapist_id,
                                                            $note); 
            }
            else{
                mysqli_stmt_bind_param($statement, 'ii', $last_id,
                                                            $therapist_id); 
            }
            
            $success = mysqli_stmt_execute($statement);
            
            
            



            if($success){
                header("location: ../home/home.php?notification=true&success=true&message=Added patient and assigned to therapist sucessfully"); 
            }
            else{
                header("location: ../home/home.php?notification=true&success=false&message=Added user but failed to assign to therapist"); 
            }
        }else{
            header("location: ../home/home.php?notification=true&success=true&message=Added user sucessfully"); 
        }
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