<?php
include "dao.php";
if (!$_SESSION["admin"]) {
    header("Location: index.php");
}
$username = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
$info = getInfo($username);
if ($_POST) {
    $username = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
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
    <center>
        <form action="" method="post">
            <label for="submit" style="color:red;font-size:xx-large">Etes vous sur de vouloir supprimer cet utilisateur</label>
            <br>
            <input type="submit" class="btn2" style="padding-left:10px;padding-right:10px" value="oui" name="submit">
            <input type="text" name="name" hidden id="" value="<?php echo $info[0][1]; ?>">
            <input type="text" name="lastname" hidden id="" value="<?php echo $info[0][2]; ?>">
            <a href="index.php" style="padding-left:10px;padding-right:10px" class="btn2">non</a>
        </form>
    </center>
</body>

</html>