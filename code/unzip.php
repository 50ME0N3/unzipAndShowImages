<?php
include "func.php";
//vérifie si l'utilisateur a les permission pour éffectuer cette action avant de la faire
if ($_SESSION["admin"]) {
    unzip();
}
else {
    echo "test";
}
header("location: index.php");