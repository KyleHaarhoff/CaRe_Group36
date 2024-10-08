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
    #database connection
    require_once "../../common/db/db-conn.php"; 
    


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="add-user.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main>
        <div class="shadow rounded add-user-form-container">
            <div class="form-title">
                Add User
            </div>
            <form class="add-user-form" action="add-user-backend.php" method="POST">
                <label for="first_name" ><div>First Name</div><input type="text" name="first_name" required autocomplete="off"></label>
                
                <label for="last_name"><div>Last Name</div> <input type="text" name="last_name" required autocomplete="off"></label>
                
                <label for="email"><div>Email</div> <input type="email" name="email" required autocomplete="off"></label>
                
                <label for="phone_number" ><div>Phone Number</div> <input type="text" name="phone_number" required autocomplete="off"></label>
                
                <label for="age"><div>Age</div> <input type="number" name="age" required autocomplete="off" min="1"></label>
                
                <label for="gender"><div>Gender</div> <input type="text" name="gender" autocomplete="off"></label>
                
                <div class="user-type-select-container">
                    <select name="user_type" required  onchange="toggleTherapistSelect()" id="type_select">
                        <option value="" selected disabled>User Type</option>
                        <option value="1">Patient</option>
                        <option value="2">Therapist</option>
                        <option value="3">Professional</option>
                        <option value="4">Auditor</option>
                    </select>
                </div>
                <div class="therapist-select-container">
                    <select name="therapist" id="therapist_select">
                        <option value="" selected disabled>Therapist</option>
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
                <div>
                    <textarea placeholder="Initial notes..." name="notes" id="notes_input"></textarea>
                </div>
                <div class="allign-right">
                    <input type="submit" class="careButton">
                </div>
            </form>
        </div>
    </main>

    <script src="add-user.js"> </script>

</body>

</html>