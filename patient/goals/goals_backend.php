<?php
session_start();
include_once __DIR__."/../../conf.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit("Unauthorized access");
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 1) {
    http_response_code(403);
    exit("Unauthorized access");

}






$user_id = $_SESSION['id'];
if(isset($_POST['type'])){
    switch($_POST['type']){
        case "add":
            
            $goal_text = isset($_POST['goal_text']) ? trim($_POST['goal_text']) : '';
            $goal_text = htmlspecialchars($goal_text);

            $is_completed = isset($_POST['is_completed']) ? trim($_POST['is_completed']) : 0;
            $is_completed = htmlspecialchars($is_completed);

            if ($goal_text === '') {
                http_response_code(400);
                exit("Goal text cannot be empty");
            }

            $sql = "INSERT INTO Goals (user_id, goal_text, is_completed) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $user_id, $goal_text, $is_completed);

            if ($stmt->execute()) {
                header("location: goals.php?notification=true&success=true&message=Goal added sucessfully");
            } else {
                header("location: goals.php?notification=true&success=false&message=An error occurred");
            }

            break;
        case "update":
            
            $goal_text = isset($_POST['goal_text']) ? trim($_POST['goal_text']) : '';
            $goal_text = htmlspecialchars($goal_text);

            $is_completed = isset($_POST['is_completed']) ? trim($_POST['is_completed']) : 0;
            $is_completed = htmlspecialchars($is_completed);

            $goal_id = isset($_POST['goal_id']) ? trim($_POST['goal_id']) : '';
            $goal_id = (int) htmlspecialchars($goal_id);

            if ($goal_text === '') {
                http_response_code(400);
                exit("Goal text cannot be empty");
            }

            

            $sql = "UPDATE Goals SET goal_text = ?, is_completed = ? WHERE id = ? and user_id = ?";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("siii", $goal_text, $is_completed, $goal_id, $user_id);


            if ($stmt->execute()) {

                
                header("location: goals.php?notification=true&success=true&message=Goal updated sucessfully");
            } else {
                header("location: goals.php?notification=true&success=false&message=An error occurred");
            }
            break;
        case "delete":
            $goal_id = isset($_POST['goal_id']) ? trim($_POST['goal_id']) : '';

            $sql = "DELETE FROM Goals WHERE id = ? and user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $goal_id, $user_id);

            if ($stmt->execute()) {
                header("location: goals.php?notification=true&success=true&message=Goal deleted sucessfully");
            } else {
                header("location: goals.php?notification=true&success=false&message=An error occurred");
            }
            break;
    }
    $stmt->close();
    $conn->close();
}


?>
