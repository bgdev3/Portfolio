<?php
namespace Portfolio\Models;


use Portfolio\Core\DbConnect;
use Exception;

class adminUserModel extends DbConnect
{

    public function find(string $email)
    {
        $this->request = $this->connexion->prepare('SELECT * FROM admin WHERE email = :email');
        $this->request -> bindParam(':email', $email);
        $this->request->execute();
        $admin =  $this->request->fetch();

        return $admin;
    }
}