<?php

namespace App\Controllers;

use App\Config\Security\DataSanitize;
use App\Models\LoginModel;
use App\Config\Authentification\User;

session_start();
class Login extends BaseController
{
    public function index()
    {
        $data_sanitize = new DataSanitize;
        $data_sanitize->generate_csrf_token(19723, 665458);
        echo (view('Authentification/Login.php', ["data_sanitize" => $data_sanitize]));
    }


    /**
     * login
     * Check if user's data are correct and connect the user before 
     * show login page or redirect to profile page.
     * @return void
     */
    public function login()
    {
        var_dump(empty($_POST['password']));
        var_dump($_POST);
        if (!empty($_POST['login']) && !empty($_POST['password']) && isset($_SESSION['csrf_token'])) {

            $data_sanitizer = new DataSanitize;
            $data_sanitizer->csrf_verification($_SESSION['csrf_token']);

            $login = $data_sanitizer->sanitize_var($_POST['login']);
            $password = $data_sanitizer->sanitize_var($_POST['password']);

            
            $login_model = new LoginModel;
            sleep(1);
            (object) $data = $login_model->login($login, $password);
            if (!is_null($data)) {
                $user = new User($data->id, $data->login1);
                
                $_SESSION['user'] = serialize($user);
                $_SESSION['idVisiteur'] = $data->id;
                log_message('notice', "L'utilisateur {login} viens de se connecter depuis l'ip : {ip}", ['login' => $_POST['login'], 'ip'=>$_SERVER['REMOTE_ADDR']]);
                return redirect()->to(base_url("home"));
            } else {
                log_message('warning', "Un utilisateur c'est trompé d'identifiant ou de mot de passe depuis l'ip : {ip}", ['ip'=>$_SERVER['REMOTE_ADDR']]);
                return redirect()->to(base_url("/"));
            }
        }else {
            log_message('notice', "Un utilisateur c'est trompé d'identifiant ou de mot de passe depuis l'ip : {ip}", ['ip'=>$_SERVER['REMOTE_ADDR']]);
            return redirect()->to(base_url("/"));
        }
    }
}
