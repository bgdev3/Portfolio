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
        $this->request = $this->connexion->prepare('INSERT INTO production VALUES (NULL, :title, :url, :description, :path, :createdAt, :html, :sass, :bootstrap, :js, :php, :symfony, :react, :wordpress, :idUser)');
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':url', $production->getUrl());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':path', $production->getPath());
        $this->request->bindValue(':createdAt', $production->getCreatedAt());
        $this->request->bindValue(':html', $production->getHTML());
        $this->request->bindValue(':sass', $production->getSass());
        $this->request->bindValue(':bootstrap', $production->getBootstrap());
        $this->request->bindValue(':js', $production->getJs());
        $this->request->bindValue(':php', $production->getPhp());
        $this->request->bindValue(':symfony', $production->getSymfony());
        $this->request->bindValue(':react', $production->getReact());
        $this->request->bindValue(':wordpress', $production->getWordpress());
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
     * @param int $id correspondant de l'enregistrement sélectionné
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
     * Recuprère le dernier enregistrement de la table
     * 
     * @return object
     */
    public function findLast(): object
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production ORDER BY idProduction DESC  LIMIT 1');
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
        $this->request = $this->connexion->prepare('UPDATE production SET title = :title, url = :url, description = :description, path = :path, 
        createdAt = :createdAt, html = :html, sass = :sass, bootstrap = :bootstrap, js = :js, php = :php, symfony = :symfony, react = :react, wordpress = :wordpress WHERE idProduction = :id');

        $this->request->bindValue(':id', $id);
        $this->request->bindValue(':title', $production->getTitle());
        $this->request->bindValue(':url', $production->getUrl());
        $this->request->bindValue(':description', $production->getDescription());
        $this->request->bindValue(':path', $production->getPath());
        $this->request->bindValue(':createdAt', $production->getCreatedAt());
        $this->request->bindValue(':html', $production->getHTML());
        $this->request->bindValue(':sass', $production->getSass());
        $this->request->bindValue(':bootstrap', $production->getBootstrap());
        $this->request->bindValue(':js', $production->getJs());
        $this->request->bindValue(':php', $production->getPhp());
        $this->request->bindValue(':symfony', $production->getSymfony());
        $this->request->bindValue(':react', $production->getReact());
        $this->request->bindValue(':wordpress', $production->getWordpress());
        $this->ExecuteTryCatch();
       
    }

    /**
     * Jointure entre les tables production et template
     * 
     * @param int $id Id correspondnat afin d'effectuer la jointure
     * @return array $prod jointure retournée
     */
    public function join(int $id): array
    {
        $this->request = $this->connexion->prepare('SELECT * FROM production INNER JOIN template on production.idProduction = template.idProduction  
                                                    WHERE template.idProduction = :id');
        $this->request->bindParam(':id', $id);
        $this->request->execute();
        $prod = $this->request->fetchAll();
        return $prod;
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