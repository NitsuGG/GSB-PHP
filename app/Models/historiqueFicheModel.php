<?php

namespace App\Models;

use CodeIgniter\Model;

class historiqueFicheModel extends model{

    public function getMonth(String $idVisiteur)
    {
        $db = db_connect();

        $paramverif = [$idVisiteur];
        $query = "SELECT `mois` FROM `fichefrais` WHERE idVisiteur = ?";

        $query = $db->query($query, $paramverif);

        $result = $query->getResult();

        return $result;
    }

    public function GetHistoFicheFrais(String $idVisiteur, String $month)
    {
        $db = db_connect();
        $param = [$idVisiteur, $month];
        $query = "SELECT * FROM `lignefraisforfait` WHERE `idVisiteur` = ? AND `mois` = ?";

        $query = $db->query($query, $param);
        return $query->getResult();
    }

    public function GetHistoFicheHF(String $idVisiteur, String $month)
    {
        $db = db_connect();
        
        $param = [$idVisiteur, $month];
        $query = "SELECT * FROM `lignefraishorsforfait` WHERE `idVisiteur` = ? AND `mois` = ?";
        
        $query = $db->query($query, $param);
        return $query->getResult();
    }
}