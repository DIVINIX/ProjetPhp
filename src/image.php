<?php

require('classBD.php');
$con = new connexion("ETD","ETD");
$codeMusicien = $_GET["Code"];
$con->image($codeMusicien);

?>