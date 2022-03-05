<?php

namespace App\Controllers;
class logoutController extends BaseController
{
    public function logout()
    {
        session_start();
        log_message('notice', "L'utilisateur {id} viens de se deconnecter", ['id'=>$_SESSION['idVisiteur']]);
        session_unset();
        session_destroy();  
        return redirect()->to(base_url("/"));
    }
}