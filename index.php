<?php
    include_once __DIR__."/conf.php";
    session_start();
    #check if it is a logout request
    if(isset($_GET["logout"])){
        session_unset(); 
        session_destroy();
    }
    #check for email and password and try login
    if(isset($_GET["email"]) && isset($_GET["password"])){
        require_once("common/db/db-conn.php");
        $sql = "SELECT * FROM users WHERE email=? AND password=SHA1(?);";
        
        $statement =  mysqli_stmt_init($conn);
        mysqli_stmt_prepare($statement, $sql); 
        mysqli_stmt_bind_param($statement, 'ss', $_GET["email"], $_GET["password"]);

        if($success = mysqli_stmt_execute($statement) ){
            if($result = mysqli_stmt_get_result($statement)){
                if($row = mysqli_fetch_assoc($result)){
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['user_type'] = $row['user_type'];

                    //send them to their home page
                    switch($row['user_type']){
                        case 1:
                            header("Location: patient/home/home.php");
                            break;
                        case 2:
                            header("Location: therapist/home_page/index.php");
                            break;
                        case 3:
                            header("Location: professional/home/home.php");
                            break;
                        case 4:
                            header("Location: auditor/home/home.php");
                            break;
                    }
                    exit();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
    </header>
    <main>
        <div class="loginDiv rounded shadow">
            <form id="loginForm" method="get" action="index.php">
                <p class="loginTitle">Please login</p>
                <label>
                    <div class="loginFormItem">Email</div>
                    <input required type="email" placeholder="Enter your email..." name="email" class="loginFormItem loginInput" autocomplete="email">
                </label>
                <label>
                    <div class="loginFormItem">Password</div>
                    <input required type="password" placeholder="Enter your password..." name="password" class="loginFormItem loginInput" autocomplete="off">
                </label>
                <input type="submit" value="Login" class="careButton" id="loginButton" >
            </form>
        </div>
    </main>
    <?php include "common/notification/notification.php"; ?> 
</body>
<script src="login.js"></script>
</html>