<?php
class connexion
{
    private $_user;
    private $_password;
    private $_pdodsn;

    public function __construct($user, $password)
    {
        $this->_user = $user;
        $this->_password = $password;

        $driver = 'sqlsrv';
        $host = 'INFO-SIMPLET';
        $nomDb = 'Classique_Web';
        $this->_pdodsn = "$driver:Server=$host;Database=$nomDb";
    }

    public function getUser()
    {
        return $this->_user;
    }
    public function getPassword()
    {
        return $this->_password;
    }
    public function getPDOdsn()
    {
        return $this->_pdodsn;
    }


    public function image($codeMusicien)
    {
        $pdo = new PDO($this->_pdodsn, $this->_user, $this->_password);
        $requete = "SELECT Photo FROM Musicien WHERE Code_Musicien = :nom";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':nom' => $codeMusicien));
        $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);
        $image = pack("H*", $lob);
        header("Content-Type: image/jpeg");
        echo $image;
    }

    public function musique($codeMorceau)
    {
        $pdo = new PDO($this->_pdodsn, $this->_user, $this->_password);
        $requete = "SELECT Extrait FROM Enregistrement WHERE Code_Morceau = :code";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' => $codeMorceau));
        $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);
        $image = pack("H*", $lob);
        header("Content-Type: audio/mp3");
        echo $image;
    }

}

