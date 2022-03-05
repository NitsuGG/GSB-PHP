<?php

namespace App\Controllers;

use App\Config\Security\DataSanitize;
use App\Models\ficheFraisModel;
use CodeIgniter\Log\Logger;
use Psr\Log\NullLogger;

session_start();

class ficheFraisController extends BaseController
{
    public function index()
    { 
        if (!isset($_SESSION['user'])) {
            return redirect()->to(base_url("/"));
        }
        $FicheFraisModel = new ficheFraisModel;
        $data_sanitizer = new DataSanitize;

        if ($FicheFraisModel->FicheExiste($_SESSION['idVisiteur']) == false) {
            $FicheFraisModel->Createfiche($_SESSION['idVisiteur']);
        }

        $historique = $FicheFraisModel->getHistoMonth($_SESSION['idVisiteur']);
        $historiquehf = $FicheFraisModel->getHorsForfais($_SESSION['idVisiteur']);
        $totalHf = 0;

        foreach ($historiquehf as $key => $value) {
            $totalHf = $totalHf + intval($value->montant);
        }

        $total = intval($historique[0]->quantite) + intval($historique[1]->quantite) + intval($historique[2]->quantite) + intval($historique[3]->quantite) + $totalHf;
        echo (view('bloc/header.php'));
        echo (view('ficheFrais.php', [
            "historique" => $historique,
            "totalHf" => $totalHf,
            "total" => $total,
            "data_sanitizer"=>$data_sanitizer
        ]));
        echo (view('bloc/footer.php'));
    }

    /**
     * send_value
     *
     * @return void
     */
    public function send_value()
    {
        if (isset($_POST['type_frais']) && isset($_POST['value_price'])) {
            $data_sanitizer = new DataSanitize;
            $data_sanitizer->csrf_verification($_SESSION['csrf_token']); 

            $FicheFraisModel = new ficheFraisModel;

            $typeFrais = $data_sanitizer->sanitize_var($_POST['type_frais']);
            $valuePrice = $data_sanitizer->sanitize_var($_POST['value_price']);

            log_message('info', "{id} à inserer des valeurs dans fiche frais. Les valeurs ajouter sont {typeFrais} (Type de frais) et {valuePrice} (Le nombre associer au type de frais)", ['id'=>$_SESSION['idVisiteur'],'typeFrais'=>$typeFrais, 'valuePrice'=>$valuePrice]);


            if (is_numeric($valuePrice)) {
                intval($valuePrice);

                switch ($typeFrais) {
                    case 'ETP':
                        $valuePrice = $valuePrice * $FicheFraisModel->GetRefund("ETP")->montant;
                        break;
                    case 'KM':
                        $valuePrice = $valuePrice * $FicheFraisModel->GetRefund("KM")->montant;
                        break;
                    case 'NUI':
                        $valuePrice = $valuePrice * $FicheFraisModel->GetRefund("NUI")->montant;
                        break;
                    case 'REP':
                        $valuePrice = $valuePrice * $FicheFraisModel->GetRefund("REP")->montant;
                        break;
                    default:
                        echo ("Aucune valeur rentrée");
                        break;
                }
                $idVisiteur = $data_sanitizer->sanitize_var($_SESSION['idVisiteur']);
                $mois = date("FY");

                $FicheFraisModel->SendValue($idVisiteur, $mois, $typeFrais, $valuePrice);
            }
        }

        if(isset($_POST['name_libelle']) && isset($_POST['value_priceHF'])){

            $data_sanitizer = new DataSanitize;
            $data_sanitizer->csrf_verification($_SESSION['csrf_token']); 

            $FicheFraisModel = new ficheFraisModel;
            $data_sanitizer = new DataSanitize;

            $libelleName = $data_sanitizer->sanitize_var($_POST['name_libelle']);
            $valuePriceHF = $data_sanitizer->sanitize_var($_POST['value_priceHF']);

            $FicheFraisModel->Hfsend($_SESSION['idVisiteur'], $libelleName, $valuePriceHF);

                        log_message('info', "{id} à inserer des valeurs dans fiche frais hors forfait. Les valeurs ajouter sont {typeFrais} (Type de frais) et {valuePrice} (Le nombre associer au type de frais)", ['id'=>$_SESSION['idVisiteur'],'typeFrais'=>$libelleName, 'valuePrice'=>$valuePriceHF]);


        }

        $this->index();
    }
}
