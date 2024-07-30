<?php 
namespace Portfolio\Models;

use Portfolio\Core\DbConnect;
use Portfolio\Entities\Production;
use Exception;

class ProductionModel  extends DbConnect
{

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
     * Récupère tous les enregistrements
     * 
     * @return array
     */
    public function findAll(): array
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production');
        $this->request->execute();
        $list = $this->request->fetchAll();
        return $list;
    }


    /**
     * Récupère un enregistrement par l'id correspondnat
     * 
     *@param int $id correspondant de l'enregistrement sélectionné
     * @return object
     */
    public function find(int $id): object
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production WHERE idProduction = :id');
        $this->request->bindParam(':id', $id);
        $this->request->execute();
        $prod = $this->request->fetch();
        return $prod;
    }


    /**
     * Récupère un enregistrement par l'id correspondnat
     * 
     *@param int $id correspondant de l'enregistrement sélectionné
     * @return object
     */
    public function update(int $id, Production $production)
    {
        $this->request = $this->connexion->prepare('UPDATE production SET title = :title, description = :description, path = :path, 
        createdAt = :createdAt WHERE idProduction = :id');

        $this->request->bindValue(':id', $id);
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':path', $production->getPath());
        $this->request->bindValue(':createdAt', $production->getCreatedAt());
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