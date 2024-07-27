<?php 

namespace Portfolio\Models;

use Portfolio\Core\DbConnect;
use Exception;
use Portfolio\Entities\Production;

class ProductionModel  extends DbConnect
{

    public function find($id): object
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production WHERE id = :id');
        $this->request->bindParam(':id', $id);
        $prod = $this->request->fetch();
         return $prod;
    }
    // Créé un nouvel enregistrement dans la table
    public function create(Production $production): void
    {
        $this->request = $this->connexion->prepare('INSERT INTO production VALUES (NULL, :title, :description, :createdAt, :idUser)');
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':createdAt', $production->getCreatedAt());
        $this->request->bindValue(':idUser', $production->getIdUser());

        $this->ExecuteTryCatch();
    }

    private function ExecuteTryCatch(): void
    {
        try {
            $this->request->execute();
        } catch(Exception $e) {
            die('Erreur : ' .$e->getMessage());
        }
    }
}