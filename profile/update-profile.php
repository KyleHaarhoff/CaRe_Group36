<?php
    #Access control
    include_once "../conf.php";
    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
        exit();
    }


    //check if we are updating or not 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES["image"])){
            //make the update
             #create the query
            $sql = "UPDATE Users SET profile_image = ? WHERE id = ?" ;
            $statement =  mysqli_stmt_init($conn);
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            mysqli_stmt_prepare($statement, $sql); 

            mysqli_stmt_bind_param($statement, 'si', $image_data,
                                                    $_SESSION['id']
                                                    ); 

            $flag = mysqli_stmt_execute($statement);
        }

        if(isset($_POST['password'])){
            $sql = "UPDATE Users SET password = SHA1(?) WHERE id = ?" ;
            $statement =  mysqli_stmt_init($conn);
            $password = $_POST['password'];
            mysqli_stmt_prepare($statement, $sql); 

            mysqli_stmt_bind_param($statement, 'si', $password,
                                                    $_SESSION['id']
                                                    ); 

            $flag = mysqli_stmt_execute($statement);

        }
    }


    $sql= "SELECT * FROM Users where id = ?;";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

        mysqli_stmt_execute($stmt);
        if($result = mysqli_stmt_get_result($stmt)) {
            $user=mysqli_fetch_assoc($result);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="update-profile.css">
</head>
<body>
    <header>
        <?php include "../common/navbar/navbar.php"; ?>
    </header>
    <div class="profile shadow rounded">
            <?php
            if ($user['profile_image']) {
                // Output the image data
                ?>
                <img src="user-profile-image.php" alt="Profile Picture" class="profile-img" id="profile-img">
                <?php
            } else {
                ?>
                <img src="../assets/images/default_profile.svg" alt="Profile Picture" class="profile-img" id="profile-img">
                <?php
            }
            ?>
            <h1><?= $user['first_name'] . ' '. $user['last_name']?></h1>
            <form  method="POST" enctype="multipart/form-data">
                <input type="file" name="image" accept="image/*"  class="fileUpload" id="file-upload">
                <input type="submit" value="Save" class="careButton">
            </form>
            <form  method="POST" class="password-container">
                <input type="password" name="password" class="password">
                <input type="submit" value="Update Password" class="careButton">
            </form>
        </div>
    <input id="flag" type="hidden" value="<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 1;
        }
    ?>" data-flag="<?php
    if ($flag) {
        echo 1;
    }
?>" >
    <?php include "../common/notification/notification.php"; ?> 
</body>
</html>
<script src="update-profile.js"></script>