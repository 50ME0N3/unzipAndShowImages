<?php
include "dao.php";
if (!$_SESSION["admin"]) {
    header("Location: index.php");
}
$_username = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
$info = getInfo($_username);
if ($_POST) {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $pwd = md5(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
    update($username,$pwd, $id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
<div class="login-box">
    <h2>Update</h2>
    <form autocomplete="off" id="my_form" method="post">
        <div class="user-box">
            <input type="text" name="username" id="username" required value="<?php echo $info[0][1]; ?>">
            <label for="username">Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" id="password" required>
            <label for="password">Password</label>
        </div>
        <input type="number" name="id" hidden value="<?php echo $info[0][0] ?>">
        <a href="javascript:{}" onclick="document.getElementById('my_form').submit();">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Submit
        <a/>
    </form>
</div>
</body>

</html>