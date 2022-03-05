<?php

namespace App\Controllers;
class Home extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {  
            header('location: /');
        }

        echo(view('bloc/header.php'));
        echo(view('Home.php'));
        echo(view('bloc/footer.php'));
    }
}
