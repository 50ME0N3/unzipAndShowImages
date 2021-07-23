<?php
include "dao.php";
//si l'utilisateur n'a pas les permission pour être sur cette page alors on le renvoie sur l'index
if (!$_SESSION["admin"]) {
    header("Location: index.php");
}

$username = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
$info = getInfo($username);
if (isset($_POST["username"])) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    delete($username);
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
    <h2>Etes vous sur de vouloir supprimer cet utilisateur ?</h2>
    <form autocomplete="off" id="my_form" method="post">
        <input type="text" name="username" hidden id="" value="<?php echo $info[0][1]; ?>">
        <a href="javascript:{}" onclick="document.getElementById('my_form').submit();">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Oui
            <a/>

            <a style="float: right;" href="javascript:{}" onclick="document.location.href = " allUsers.php"">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Non
            <a/>
    </form>
</div>
</body>

</html>