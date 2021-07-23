<?php
session_start();
//si l'utilisateur est connecter on affiche sinon on redirige sur l'index
if ($_SESSION["username"] != null) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="css/user.css">
    </head>
    <body>
    <div class="login-box">
        <a href="index.php"><h2>Tu es</h2></a>
        <form autocomplete="off" id="my_form" method="post">
            <div class="user-box">
                <input type="text" name="username" id="username" readonly required="">
                <label for="username"><?php echo $_SESSION["username"] ?></label>
            </div>
            <a href="javascript:{}" onclick="document.location.href = 'deco.php' ">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Se déconnecter
                <a href="javascript:{}"
                   onclick="document.location.href = 'UpdateWithoutAdminPerks.php?name=<?php echo $_SESSION["username"]; ?>'">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Modifier son profile
        </form>
    </div>
    </body>
    </html>
    <?php
} else {
    header("location: index.php");
}
?>