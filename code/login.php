<?php
include "dao.php";
if(isset($_POST["username"])){
   login(filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING),md5(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING)));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Document</title>
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <form autocomplete="off" id="my_form" method="post">
            <div class="user-box">
                <input type="text" name="username" required="">
                <label for="username">Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required="">
                <label for="password">Password</label>
            </div>
            <a href="javascript:{}" onclick="document.getElementById('my_form').submit();">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Submit
            </>
        </form>
    </div>
</body>

</html>