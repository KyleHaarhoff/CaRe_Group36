<?php
    include_once __DIR__."/conf.php"
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
                <p class="loginTitle">Please log in</p>
                <label>
                    <div class="loginFormItem">Email</div>
                    <input type="text" placeholder="Enter your email..." name="email" class="loginFormItem loginInput" autocomplete="email">
                </label>
                <label>
                    <div class="loginFormItem">Password</div>
                    <input type="password" placeholder="Enter your password..." name="password" class="loginFormItem loginInput" autocomplete="off">
                </label>
                <input type="submit" value="Login" class="careButton" id="loginButton" >
            </form>
        </div>
    </main>
</body>
<script src="login.js"></script>
</html>