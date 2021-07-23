<?php
include "dao.php";
//permet la modification que si la personne est admin
if (!$_SESSION["admin"]) {
    header("Location: index.php");
}
$_username = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
//recupère les informations de la base de l'utilisateur sélectionné
$info = getInfo($_username);
//met l'id en session pour evité toute personne de vouloir modifier une autre personne que la personne sélectionné
$_SESSION["id"] = $info[0][0];
if ($_POST) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $pwd = md5(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
    update($username, $pwd, $_SESSION["id"]);
    //remet l'id a null pour eviter que l'id reste en session et qu'ils puissent être utilisé de toute autre façon que celle voulu a la base
    $_SESSION["id"] = null;
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de <?php echo $info[0][1]; ?></title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
<div class="login-box">
    <a href="index.php"><h2>Modification</h2></a>
    <form autocomplete="off" id="my_form" method="post">
        <div class="user-box">
            <input type="text" name="username" id="username" required value="<?php echo $info[0][1]; ?>">
            <label for="username">Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" id="password" required>
            <label for="password">Password</label>
        </div>
        <!--Permet l'envoie du form sans d'input de type submit-->
        <a href="javascript:{}" onclick="document.getElementById('my_form').submit();">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Modifier
    </form>
</div>
</body>

</html>