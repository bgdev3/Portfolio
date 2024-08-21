<?php 
namespace Portfolio\Models;

use Portfolio\Core\DbConnect;
use Portfolio\Entities\Template;
use Exception;

class TemplateModel extends DbConnect
{
    public function create(Template $template)
    {
        $this->request = $this->connexion-> prepare("INSERT INTO template VALUES(NULL, :path1, :path2, :path3, :path4, :comments, :idProduction)");
        $this->request->bindValue(':path1', $template->getPath1());
        $this->request->bindValue(':path2', $template->getPath2());
        $this->request->bindValue(':path3', $template->getPath3());
        $this->request->bindValue(':path4', $template->getPath4());
        $this->request->bindValue(':comments', $template->getComments());
        $this->request->bindValue(':idProduction', $template->getIdProduction());
        $this->ExecuteTryCatch();
    }


    /**
     * Effectue une mise à jour de l'enregistrement correspondant à l'id
     * @param object Template Entité à enregistrer
     * @param int $id Id de l'enregistrement à mettre à jour
     */
    public function update(Template $template, int $id)
    {
        $this->request = $this->connexion->prepare("UPDATE template SET template1 = :path1, template2 = :path2, template3 = :path3, template4 = :path4,
                                                    comments = :comments WHERE idProduction = :id");
        $this->request->bindValue(':id', $id);
        $this->request->bindValue(':path1', $template->getPath1());
        $this->request->bindValue(':path2', $template->getPath2());
        $this->request->bindValue(':path3', $template->getPath3());
        $this->request->bindValue(':path4', $template->getPath4());
        $this->request->bindValue(':comments', $template->getComments());
        $this->ExecuteTryCatch();
    }


    private function ExecuteTryCatch()
    {
        try{
            $this->request->execute();
        }catch(Exception $e){
            die('Erreur: ' . $e->getMessage());
        }
    }
}