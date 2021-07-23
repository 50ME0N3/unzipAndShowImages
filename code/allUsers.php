<?php
include "dao.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/allUsers.css">
    <title>Document</title>
</head>
<body>
<?php
//affiche tout les utilisateur si l'utilisateur en a les permissions
if ($_SESSION["admin"] == true) {
    echoAllUsers();
} else {
    header("location: index.php");
}
?>
<button class="btn btn-outline-light" onclick="document.location.href = 'index.php'">Retour a l'index</button>
</body>
</html>

