<?php
include "dao.php";
if($_SESSION["admin"] == true) {
    echoAllUsers();
}
else{
    header("location: index.php");
}