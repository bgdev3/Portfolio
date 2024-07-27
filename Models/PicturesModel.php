<?php 
namespace Portfolio\Models;

use Exception;
use Portfolio\Core\DbConnect;
use portfolio\Entities\Pictures;

class PicturesModel extends DbConnect
{
    public function create(Pictures $picture)
    {
        $this->request = $this->connexion->prepare("INSERT INTO pictures VALUES (NULL, :size_slide, :path, :idProduction)");
        $this->request->bindValue(':size_slide', $picture->getSize_slide());
        $this->request->bindValue(':path', $picture->getPath());
        $this->request->bindValue(':idProduction', $picture->getIdProduction());

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