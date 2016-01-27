<?php

$nom = $_POST["Nom"];
$prenom = $_POST["Prénom"];
$login = $_POST["Login"];
$password = $_POST["Password"];

require('classAbonne.php');
$con = new classAbonne("ETD","ETD");
$con->modifierProfil($nom,$prenom,$login,$password);

?>