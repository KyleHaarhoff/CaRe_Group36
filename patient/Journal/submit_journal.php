<?php
session_start(); // Start the session to access session variables
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 1) {
    http_response_code(403);
    echo "<h1>403 Forbidden</h1>";
    echo "<p>You are not authorized to access this page.</p>";

    exit();
}

include '../../common/db/db-conn.php'; // Include your database connection



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $journal_date = htmlspecialchars($_POST['journal-date']);
    $hours_slept = htmlspecialchars($_POST['hours-slept']);
    $mood = htmlspecialchars($_POST['mood']);
    $meals_eaten = htmlspecialchars($_POST['meals-eaten']);
    $exercise = isset($_POST['exercise']) ? 1 : 0; // Convert checkbox to boolean
    $journal_entry = htmlspecialchars($_POST['journal-entry']);

    

    // Prepare SQL INSERT statement
    $sql = "INSERT INTO journal_entries (patient_id, journal_date, hours_slept, mood, meals_eaten, exercise, journal_entry) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('isisiis', $_SESSION['id'], $journal_date, $hours_slept, $mood, $meals_eaten, $exercise, $journal_entry);
        

        // Execute statement
        if ($stmt->execute()) {
            //If we have files
            if ($_FILES['files']["tmp_name"][0] != "") {
                $last_id = $conn->insert_id;
                $flag = false;
                foreach ($_FILES['files']["tmp_name"] as $file){
                    $sql = "INSERT INTO journal_images (journal_id, image_data) VALUES (?,?) ;" ;
                    $statement =  mysqli_stmt_init($conn);
                    $image_data = file_get_contents($file);
                    mysqli_stmt_prepare($statement, $sql); 

                    mysqli_stmt_bind_param($statement, 'is', 
                                                $last_id,
                                                $image_data); 
                    if (!mysqli_stmt_execute($statement))
                        $flag = true;

                }
                if (!$flag){
                    header("location: ../home/home.php?notification=true&success=true&message=Successfully Saved Journal");
                } else {
                    header("location: goals.php?notification=true&success=false&message=Saved Journal but not images");
                }
                }
                else{
                    header("location: ../home/home.php?notification=true&success=true&message=Successfully Saved Journal");
                }
            
        } else {
            header("location: goals.php?notification=true&success=false&message=An error occurred");
        }
        
        $stmt->close(); // Close statement
    } else {
        header("location: goals.php?notification=true&success=false&message=Saved Journal but not images");
    }

    $conn->close(); // Close database connection
} else {
    echo "Invalid request method."; // Handle invalid request method
}
?>
