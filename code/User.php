<?php
session_start();
if($_SESSION["username"] != null){
    var_dump($_SESSION);
}