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
    if(!isset($_GET['id'])){
        exit("???");
    }
    #database connection
    require_once "../../common/db/db-conn.php"; 
    
    $sql= "SELECT * FROM Users Where id = ?;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            $user_id = htmlspecialchars($_GET['id']);
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
                
            mysqli_stmt_execute($stmt);
            if($result = mysqli_stmt_get_result($stmt)) {
                $user_info=mysqli_fetch_assoc($result);
        }
    }
    
    if($user_info['user_type'] == 1){
        
        $sql= "SELECT * FROM Users LEFT JOIN patient_therapist ON patient_therapist.patient_id=users.id Where patient_id = ? LIMIT 1;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            $user_id = htmlspecialchars($_GET['id']);
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
                
            mysqli_stmt_execute($stmt);
            if($result = mysqli_stmt_get_result($stmt)) {
                $therapist=mysqli_fetch_assoc($result);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="view-user.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main>
        <div class="shadow rounded add-user-form-container">
            <div class="form-title">
                User Information
            </div>
            <form class="add-user-form" action="update-user-backend.php" method="POST">
                <label for="first_name" ><div>First Name</div><input type="text" name="first_name" required autocomplete="off" value="<?= $user_info['first_name'] ?>"></label>
                
                <label for="last_name"><div>Last Name</div> <input type="text" name="last_name" required autocomplete="off"  value="<?= $user_info['last_name'] ?>"></label>
                
                <label for="email"><div>Email</div> <input type="email" name="email" required autocomplete="off"  value="<?= $user_info['email'] ?>"></label>
                
                <label for="phone_number" ><div>Phone Number</div> <input type="text" name="phone_number" required autocomplete="off"  value="<?= $user_info['phone_number'] ?>"></label>
                
                <label for="age"><div>Age</div> <input type="number" name="age" required autocomplete="off" min="1"  value="<?= $user_info['age'] ?>"></label>
                
                <label for="gender"><div>Gender</div> <input type="text" name="gender" autocomplete="off"  value="<?= $user_info['gender'] ?>"></label>
                <input type="hidden" value="<?=  $user_id ?>" name="user_id">
                <div class="therapist-select-container <?php
                if($user_info['user_type'] != 1){
                    echo "hidden";
                }
                ?>">
                    <select disabled name="therapist" id="therapist_select" <?php
                    if (isset($therapist)){
                        ?> value="<?= $therapist['therapist_type'] ?>"<?php
                        }
                    ?>>
                        <option value="" disabled>Therapist</option>
                        <?php
                        $sql= "SELECT * FROM Users where user_type = 2;";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_execute($stmt);
    
                            if($result = mysqli_stmt_get_result($stmt)) {
                            if(mysqli_num_rows($result)> 0) {
                                while($row=mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['first_name'] ?> <?= $row['last_name'] ?></option>
                                    <?php
                                }
                                mysqli_free_result($result);
                            }
                            }
                        }
                        ?>
                        
                    </select>
                </div>
                <div class="allign-right">
                    <input type="submit" class="careButton" value="Update">
                </div>
            </form>
        </div>
    </main>

    <script src="add-user.js"> </script>

</body>

</html>