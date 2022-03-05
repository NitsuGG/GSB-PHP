<?php

namespace App\Models;

use CodeIgniter\Model;

class ficheFraisModel extends Model
{

    /**
     * GetFrais
     * Return all date from table form_answer
     * @return $result
     */
    public function GetFrais(String $idVisiteur, String $mois, $idFraisForfais)
    {
        $db = db_connect();

        $paramverif = [$idVisiteur, $mois, $idFraisForfais];
        $query = "SELECT quantite FROM `lignefraisforfait` WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = ?";

        $query = $db->query($query, $paramverif);

        $result = $query->getResult()[0];

        return $result->quantite;
    }

    /**
     * GetRefund
     * Trouve le prix de facturation du libéllé
     * @param  String $libelle
     * @return Object
     */
    public function GetRefund(String $libelle)
    {
        $db = db_connect();
        $param = [$libelle];
        $query = "SELECT `montant` FROM `fraisforfait` WHERE `id` = ?";
        $query = $db->query($query, $param);
        $result = $query->getResult()[0];
        return $result;
    }




    /**
     * SendValue
     * Envoie la valeur séléctionné dans la base de donnée
     * @param  String $idVisiteur
     * @param  String $mois
     * @param  String $type
     * @param  Int $valuePrice
     * @return void
     */
    public function SendValue(String $idVisiteur, String $mois, String $type, Int $valuePrice): void
    {
        $db = db_connect();

        //*Verif si il y a déjà une fiche pour ce mois ci, Si non on l'a créer
        if ($this->FicheExiste($idVisiteur) == false) {
            $this->Createfiche($idVisiteur);
        }

        //*Verif si il y a déjà ce type de forfait
        $paramverif = [$idVisiteur, $mois, $type];
        $verifQuery = "SELECT * FROM `lignefraisforfait` WHERE `idVisiteur` = ? AND `mois` = ? AND `idFraisForfait` = ?";

        $result = $db->query($verifQuery, $paramverif);


        if (!isset($result->getResult()[0])) {
            //? Si il n'existe pas on INSERT

            $param = [$idVisiteur, $mois, $type, $valuePrice];

            $query = "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`,`idFraisForfait`, `quantite`) VALUES (?, ?, ?, ?)";
            $query = $db->query($query, $param);
        } else {
            //? Si il existe déjà on UPDATE

            $valuePrice = $valuePrice + (int)$this->GetFrais($idVisiteur, $mois, $type);
            $param = [$valuePrice, $idVisiteur, $mois, $type];
            $query = "UPDATE `lignefraisforfait` SET `quantite` = ?  WHERE `idVisiteur` = ? AND `mois` = ? AND `idFraisForfait` = ?";

            $query = $db->query($query, $param);
        }
    }

    /**
     * Createfiche
     * Créer une fiche au visiteur au mois actuelle
     * @param  String $idVisiteur
     * @return void
     */
    public function Createfiche(String $idVisiteur)
    {
        $db = db_connect();
        $mois = date("FY");
        $param = [$idVisiteur, $mois];
        $query = "INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES(?,?,'0','0','2021-10-13','CR')";

        $query = $db->query($query, $param);

        $param = [$idVisiteur, $mois];

        $queryETP = "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`,`idFraisForfait`, `quantite`) VALUES (?, ?, 'ETP', 0)";
        $queryKM =  "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`,`idFraisForfait`, `quantite`) VALUES (?, ?, 'KM', 0)";
        $queryNUI = "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`,`idFraisForfait`, `quantite`) VALUES (?, ?, 'NUI', 0)";
        $queryREP = "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`,`idFraisForfait`, `quantite`) VALUES (?, ?, 'REP', 0)";
         $queryETP = $db->query($queryETP, $param);
         $queryKM = $db->query($queryKM, $param);
         $queryNUI = $db->query($queryNUI, $param);
         $queryREP = $db->query($queryREP, $param);
        

        
    }

    /**
     * FicheExiste
     * Verifie que pour le mois une fiche existe pour l'utilisateur
     * @param  Sring $idVisiteur
     * @return bool
     */
    public function FicheExiste(String $idVisiteur): bool
    {
        $db = db_connect();

        $mois = date("FY");
        $param = [$idVisiteur, $mois];
        $query = "SELECT * FROM `fichefrais` WHERE `idVisiteur` = ? AND `mois`= ?";
        $query = $db->query($query, $param);
        $result = $query->getResult();

        if (isset($result[0])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * getHistoMonth
     * Retourne tout les rembourcement de l'utilisateur du mois actuel
     * @param  String $idVisiteur
     * @return void
     */
    public function getHistoMonth(String $idVisiteur)
    {
        $db = db_connect();
        $mois = date("FY");
        $param = [$idVisiteur, $mois];
        $query = "SELECT * FROM `lignefraisforfait` WHERE `idVisiteur` = ? AND `mois` = ?";

        $query = $db->query($query, $param);
        return $query->getResult();
    }

    public function Hfsend(String $idVisiteur, String $libelle, String $ValuePrice)
    {
        $db = db_connect();
        $mois = date("FY");
        $param = [$idVisiteur, $mois, $libelle, $ValuePrice];
        $query = "INSERT INTO `lignefraishorsforfait` (`idVisiteur`, `mois`, `libelle`, `date`, `montant`)
        VALUES (?, ?, ?, now(), ?)";

        $query = $db->query($query, $param);
    }
    
    public function getHorsForfais(String $idVisiteur)
    {
        $db = db_connect();

        $mois = date("FY");
        $param = [$idVisiteur, $mois];
        $query = "SELECT * FROM `lignefraishorsforfait` WHERE `idVisiteur` = ? AND `mois` = ?";

        $query = $db->query($query, $param);
        return $query->getResult();
    }
}
