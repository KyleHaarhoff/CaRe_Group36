<?php
    #Access control

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
                <div class="user-type-select-container">
                    <select name="user_type" required>
                        <option value="" selected disabled>User Type</option>
                        <option value="1">Patient</option>
                        <option value="2">Therapist</option>
                        <option value="3">Professional</option>
                        <option value="4">Auditor</option>
                    </select>
                </div>
                <div>
                    <textarea placeholder="Initial notes..." name="notes" id="notes_input"></textarea>
                </div>
                <div class="allign-right">
                    <input type="file" multiple="multiple" name="patient_files">
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