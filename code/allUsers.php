<?php
include "dao.php";
//affiche tout les utilisateur si l'utilisateur en a les permissions
if($_SESSION["admin"] == true) {
    echoAllUsers();
}
else{
    header("location: index.php");
}