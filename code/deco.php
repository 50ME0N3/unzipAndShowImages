<?php
//vide la session
session_start();
session_destroy();
$_SESSION = array();
header("location: index.php");