<?php 
namespace Portfolio\Models;

use Portfolio\Core\DbConnect;
use Portfolio\Entities\Production;
use Exception;

class ProductionModel  extends DbConnect
{

    /**
     * Récupère un eneregistrement par le titre de la création
     * 
     * @param string $title Titre de la production à récupérer
     * @return object
     */
    public function findAll(): array
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production');
        $this->request->execute();
        $list = $this->request->fetchAll();
        return $list;
    }

    
    /**
     * Créé un nouvel enregistrement dans la table
     * 
     * @param object $production Injection de dépendance
     */
    public function create(Production $production): void
    {
        $this->request = $this->connexion->prepare('INSERT INTO production VALUES (NULL, :title, :description, :path, :createdAt, :idUser)');
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':path', $production->getPath());
        $this->request->bindValue(':createdAt', $production->getCreatedAt());
        $this->request->bindValue(':idUser', $production->getIdUser());

        $this->ExecuteTryCatch();
    }


    /**
     * Supprime un enregistrement
     * 
     * @param int $id Id de l'enregistrement à supprimer
     */
    public function delete($id)
    {
        $this->request = $this->connexion->prepare('DELETE FROM production WHERE idProduction = :idProduction');
        $this->request->bindParam(':idProduction', $id);
        $this->ExecuteTryCatch();
    }


    /**
     * Teste l'execution de l arequpete dans un try catch
     *
     */
    private function ExecuteTryCatch(): void
    {
        try {
            $this->request->execute();
        } catch(Exception $e) {
            die('Erreur : ' .$e->getMessage());
        }
    }
}