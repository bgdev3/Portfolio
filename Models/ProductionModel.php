<?php 

namespace Portfolio\Models;

use Portfolio\Core\DbConnect;
use Exception;
use Portfolio\Entities\Production;

class ProductionModel  extends DbConnect
{
    // Créé un nouvel enregistrement dans la table
    public function create(Production $production): void
    {
        $this->request = $this->connexion->prepare('INSERT INTO portfolio VALUES (NULL, :title, :path, :descritpion, :createdAt, :idUser');
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':path', $production->getPath());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':createdAt', $production->getCreateAt());
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