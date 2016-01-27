<?php
require('classBD.php');

class classAbonne extends connexion
{

    public function __construct($user, $password)
    {
        parent::__construct($user,$password);
    }

    public function inscription($nom, $prenom, $login, $pass)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "INSERT INTO Abonné (Nom_Abonné, Prénom_Abonné, Login, Password) values(:nom,:prenom,:login,:pass)";
        $stmt=$pdo->prepare($requete);
        if($stmt->execute(array(':nom' => $nom,
            ':prenom' => $prenom,
            ':login' => $login,
            ':pass' => $pass
        )))
        {
            header("Location: ../connexion.php");
        }
        else {
            echo'<div class="alert alert-danger" role="alert">';
            echo'<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
            echo '  <span class="sr-only">Error:</span>';
            echo ' Login déjà existant ou couple Nom et Prénom déjà existant !';
            echo ' </div>';
        }
    }

    public function connexion($login,$password)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT * FROM Abonné WHERE Login = :login AND password =:password";
        $stmt = $pdo->prepare($requete);
        if($stmt->execute(array(':login' => $login,
            ':password' => $password))) {
            session_start();
            $_SESSION["NOM_USER"] = $login;
            $panier = array();
            $_SESSION["PANIER"] = $panier;
            header("Location: ../profil.php");
        }
        else
            header("Location: ../connexion.php?connex=false");
    }

    public function infoProfil()
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT Nom_Abonné, Prénom_Abonné, Login, Password FROM Abonné WHERE Login = '".$_SESSION["NOM_USER"]."'";
        $stmt = $pdo->query($requete);
        $resultat = $stmt->fetch();

        echo "<p>Nom : ".$resultat[utf8_decode('Nom_Abonné')]."</p>";
        echo "<p>Prénom : ".$resultat[utf8_decode('Prénom_Abonné')]."</p>";
        echo "<br>";
        echo "<p>Login : ". $resultat['Login'] ."</p>";
        echo "<p>Password : ". $resultat['Password'] ."</p>";

    }

    public function arrayProfil()
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT Nom_Abonné, Prénom_Abonné, Login, Password FROM Abonné WHERE Login = '".$_SESSION["NOM_USER"]."'";
        $stmt = $pdo->query($requete);
        $resultat = $stmt->fetch();

        $array = array($resultat[utf8_decode('Nom_Abonné')],$resultat[utf8_decode('Prénom_Abonné')],$resultat['Login'],$resultat['Password']);
        return $array;
    }

    public function modifierProfil($nom,$prenom,$login,$password)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "UPDATE Abonné SET Nom_Abonné = :nom, Prénom_Abonné = :prenom, Login = :login, Password = :pass WHERE Login = '".$_SESSION["NOM_USER"]."'";
        $stmt=$pdo->prepare($requete);
        $stmt->execute(array(':nom' => $nom,
            ':prenom' => $prenom,
            ':login' => $login,
            ':pass' => $password
        ));
        header("Location: ../profil.php");

    }

}