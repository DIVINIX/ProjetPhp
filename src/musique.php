<?php

require('classBD.php');
$con = new connexion("ETD","ETD");
$codeMorceau = $_GET["Code"];
$con->musique($codeMorceau);

?>