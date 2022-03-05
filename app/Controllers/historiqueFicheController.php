<?php

namespace App\Controllers;

use App\Config\Security\DataSanitize;
use App\Models\historiqueFicheModel;
use App\Controllers\ficheFraisController;

session_start();

class historiqueFicheController extends BaseController
{
    public function index(Array $fraisForfais = null, Array $ligneHF = null)
    {
        if (!isset($_SESSION['user'])) {
            return redirect()->to(base_url("/"));
        }

        $historiqueMonth = new historiqueFicheModel();
        $result = $historiqueMonth->getMonth($_SESSION['idVisiteur']);

        echo (view('bloc/header.php'));
        echo (view('historiqueFicheView.php', ["result"=>$result,
                                               "fraisForfais"=>$fraisForfais,
                                               "ligneHF" =>$ligneHF]));
        echo (view('bloc/footer.php'));
    }

    public function findFiche()
    {
        $data_sanitizer = new DataSanitize;
        $historiqueMonth = new historiqueFicheModel();

        $idVisiteur = $data_sanitizer->sanitize_var($_SESSION['idVisiteur']);
        $month = $data_sanitizer->sanitize_var($_POST['selectMonth']);

        $ligneFF = $historiqueMonth->GetHistoFicheFrais($idVisiteur, $month);
        $ligneHF = $historiqueMonth->GetHistoFicheHF($idVisiteur, $month);

        $totalEtape = null;
        $totalNuit = null;
        $totalKm = null;
        $totalRep = null;

        foreach ($ligneFF as $key => $value) {
            switch ($value->idFraisForfait) {
                case 'ETP':
                    $totalEtape = $totalEtape + intval($value->quantite);
                    break;
                case 'KM':
                    $totalKm = $totalKm + intval($value->quantite);
                    break;
                case 'NUI':
                    $totalNuit = $totalNuit + intval($value->quantite);
                    break;
                case 'REP':
                    $totalRep = $totalRep + intval($value->quantite);
                    break;
            }
        }
        $etape = $totalEtape/110;
        $km = $totalKm/1;
        $nuit = $totalNuit/80;
        $repas = $totalRep/25;

        $fraisForfais = [$etape, $totalEtape, $km, $totalKm, $nuit, $totalNuit, $repas, $totalRep];

        log_message('info', "L'utilisateur {id} vient de consulter la fiche du mois de {mois}", ['id' => $_SESSION['idVisiteur'], 'mois'=>$month]);


        $this->index($fraisForfais, $ligneHF);

    }
}