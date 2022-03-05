<?php
namespace App\Config\Authentification;


class User
{
    /**
     * __construct
     *
     * @param  String $id
     * @param  String $login
     * @param  String $password
     * @return void
     */
    public function __construct(String $id,String $login)
    {

        $this->id = $id;
        $this->login = $login;
    }
}
