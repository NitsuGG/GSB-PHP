<?php 

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{    
    /**
     * login
     * Return an array if $pseudo is in the data base
     * @param  string $login
     * @return bool
     * @return array
     */
    public function login(string $login,string $password): object
    {

        $dbModel = db_connect();

        $params = [$login, $password];

        $query = "SELECT * FROM visiteur WHERE login1 = ? AND mdp = ?";

        $result = $dbModel->query($query, $params);
        $result = $result->getResult()[0];

        return $result;
    }
}
