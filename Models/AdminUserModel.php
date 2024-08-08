<?php
namespace Portfolio\Models;


use Exception;
use Portfolio\Core\DbConnect;
use Portfolio\Entities\Admin;

class adminUserModel extends DbConnect
{

    /**
     * Crée un nouvel enregistrement dans la base
     * 
     * @param object $admin entoté hydraté 
     */
    public function create(Admin $admin)
    {
        $this->request = $this->connexion->prepare('INSERT INTO admin VALUES(null, :surname, :email, :password');
        $this->request -> bindValue(':surname', $admin->getSurname());
        $this->request -> bindValue(':email', $admin->getEmail());
        $this->request -> bindValue(':password', $admin->getPassword());

        $this->ExecuteTryCatch();
    }

    /**
     * Mets à jour l'enregistrement correspondant à l'id passé en paramètre
     * 
     * @param int $id Id de l'enregistrement à mettre à jour
     * @param object $admin Entité hydraté 
     */
    public function update($id, Admin $admin)
    {
        $this->request = $this->connexion->prepare("UPDATE admin SET surname = :surname, email = :email, password = :password WHERE idUser = :idAdmin");
        $this->request -> bindValue(':idAdmin', $id);
        $this->request -> bindValue(':surname', $admin->getSurname());
        $this->request -> bindValue(':email', $admin->getEmail());
        $this->request -> bindValue(':password', $admin->getPassword());

        $this->ExecuteTryCatch();
    }

    /**
     * Permet de rendre la connexion à l'utilisateur
     * 
     * @param string $email Email permettant de trouver le bon utilisateur de connexion
     */
    public function find(string $email)
    {
        $this->request = $this->connexion->prepare('SELECT * FROM admin WHERE email = :email');
        $this->request -> bindParam(':email', $email);
        $this->request->execute();
        $admin =  $this->request->fetch();

        return $admin;
    }

    /**
     * TryCatch permettant de tester la bonne execution de la requête
     */
    private function ExecuteTryCatch()
    {
        try{
            $this->request->execute();
        } catch(Exception $e) {
            die("Erreur:" . $e->getMessage());
        }

        $this->request->closeCursor();
    }
}