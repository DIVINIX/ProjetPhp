<?php

$login = $_POST["Login"];
$password = $_POST["Password"];

require('classAbonne.php');
$con = new classAbonne("ETD","ETD");
$con->connexion($login,$password);

?>
