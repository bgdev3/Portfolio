<?php
namespace Portfolio\Controllers;

use Portfolio\Entities\Production;
use Portfolio\Models\ProductionModel;

session_start();

class AdminProductionController extends Controller
{

    
    /**
     * Récupère les différentes réalisations stockées
     */
    public function index(): void{
        
        $model = new ProductionModel();
        $list = $model->findAll();

        $this->render('admin/productions/index', ['list' => $list]);
    }


    /**
     * Traite les données formulaire 
     * Récupère les données en POST, les traites puis hydate l'entité afin de les stocker en BDD
     * puis renvoi à la vue.
     * 
     */
    public function add(): void
    {
        global $error;
        // Si les champs POST et FILES ne sont pas vides
        if ($this->validatePost($_POST, ['title', 'description', 'createdAt']) && $this->validateFiles($_FILES, ['file'])) {
            // Type de fichier uploadé acceptés
            $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
            // S'il y à une erreur elle est récupéré
            $error = empty($erreur) ? $this->errorUpload($_FILES, ['file'], $type) : "" ;
            // Formate le nom de fichier stocké dans un fichier séparé
            $file = $this->formateFile($_FILES, ['file']);

            // Si l'erreur est vide
            if (empty($error)) {
                // récupère le chemin de l'image formaté
                $path = $this->imageSize($file, 500,  500);
                // Si l'image est uploadé et déplacé
                if (empty($_SESSION['error'])) {
                    // hydrate entité
                    $production = new Production();
                    $production->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES));
                    $production->setDescription(htmlspecialchars($_POST['description'], ENT_QUOTES));
                    $production->setPath($path);
                    $production->setCreatedAt(htmlspecialchars($_POST['createdAt'], ENT_QUOTES));
                    $production->setIdUser(1);
                    
                    $productionModel = new ProductionModel();
                    $productionModel->create($production);
                // Récupère et affiche le message de l'image dupliqué
                } else {
                    $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                }                                
            } 
        } else {
            $error = (!empty($_POST)) ? 'Merci de remplir correctment les champs' : '';
        }
        $this->render('admin/productions/add', ['error' => $error]);
    }
    

    /**
     * Met à jour la réalisation selectionné
     * 
     * @param int $id Id correspondant à l'enregistrement à mettre à jour
     */
    public function update($id): void
    {
        global $error;
        // Si les champs ne sont pas vides
        if ($this->validatePost($_POST, ['title', 'description', 'createdAt', 'hidden'])) {

            // Hydrate l'entité
            $production = new Production();
            $production->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES));
            $production->setDescription(htmlspecialchars($_POST['description'], ENT_QUOTES));
            $production->setCreatedAt(htmlspecialchars($_POST['createdAt'], ENT_QUOTES));
            $production->setIdUser(1);

            // Si l'image ets valide
            if($this->validateFiles($_FILES, ['file'])) {
                // Type de fichier uploadé acceptés
                $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
                // S'il y à une erreur elle est récupéré
                $error = empty($erreur) ? $this->errorUpload($_FILES, ['file'], $type) : "" ;
                // Formate le nom de fichier stocké dans un fichier séparé
                $file = $this->formateFile($_FILES, ['file']);
                
                // S'il n'y a pas d'erreur
                if(empty($error)) {
                    // récupère le chemin de l'image formaté
                    $path = $this->imageSize($file, 500,  500);
                    // Si l'image est uploadé et déplacé
                    if (empty($_SESSION['error'])) {
                        $production->setPath($path);
                    // Sinon assigne l'erreur
                    } else {
                        $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                    }
                } 
            // Sinon assigne l'image par défaut
             } else {
                $production->setPath($_POST['hidden']);
            }                                
            // Mise à jour de la bdd
            $productionModel = new ProductionModel();
            $productionModel->update($id, $production);
        // Si les champs ne sont pas correctement remplis
        } else {
            $error = (!empty($_POST)) ? 'Merci de remplir correctment les champs' : '';
        }
        // Récupère l'enregistrement correspondant par l'id
        if (isset($id)) {
            $model = new ProductionModel();
            $realisation = $model->find($id);
        }
       
        
        // Renvois vers la vue
        $this->render('admin/productions/update', ['realisation' => $realisation, 'error' => $error]);
    }


    /**
     * Supprime l'enregistrement sélectionné en bdd
     * 
     * @param int $id Id correspondant à l'enregistrement à supprimer
     */
    public function delete(int $id): void
    {
        // Si yes et déclaré et l'id aussi
        if(isset($_POST['yes']) && isset($id)) {
            // Supression de la réalisation sélectionné
            $model = new ProductionModel();
            $model->delete($id);
            // Renvoi vers la liste des réalisations
            header('location:index.php?controller=adminProduction&action=index');
        // Si no est déclaré, redirige vers la liste des réalisations
        } elseif( isset($_POST['no'])) {
            header('location:index.php?controller=adminProduction&action=index');
        // sinon renvoi vers la confirmation de suppression d'une réalisation
        } else {
            $this->render('admin/productions/confirmDelete');
        }    
    }


     /**
     * Vérifie que les données du formulaire ne sont pas vides.
     * 
     * @param array $post methode d'envoi envoyé par le formulaire
     * @param array fields Données envoyées par le formulaire
     * 
     * @return bool
     */
    private function validatePost(array $post, array $fields): bool
    {
         // Chaque champs est parcouru
         foreach( $fields as $field){
            // On teste si les champs sont vides ou déclarés
            if (empty($post[$field]) || !isset($post[$field])) {
                return false;
            }
        }
        return true;
    }


    /**
     * Tester si le fichier est bien présent et s'il n'ya pas d'erreur d'envoi
     * 
     * @param array $files Récupère la methode d'envoi
     * @param array $fields Récupère les champs de fichier 
     * 
     * @return bool
     */
    private function validateFiles(array $files, array $fields): bool  
    {
        foreach ( $fields as $field) {
           if (isset($files[$field]) && $files[$field]['error'] == 0) {
                return true;
            }
        }
        return false;
    }
        

    /**
     * Tester le fichier en cas d'envoi validé
     * et retourne un message d'erreur si le fichier ne correspond pas.
     * 
     * @param array $files Méthode d'envoi
     * @param array $fields les fichier à tester
     * @param array $type Type de fichier acceptées afin de tester les extensions de fichier
     * 
     * @return string $erreur Message d'erreur retourné
     * 
     */
    private function errorUpload(array $files, array $fields, array $type): string 
    {
        $erreur ='';
        // Parcours chaque champs
        foreach ($fields as $field) {
            // Récupère l'extension du fichier
            $ext =  pathinfo($files[$field]['name'], PATHINFO_EXTENSION);

            if (isset($files[$field]) && $files[$field]['error'] == 0) {    
                // Si l'extension correspond aux extensions autorisées
                if (in_array($_FILES[$field]['type'], $type)) {
                    // On delimite une taille max
                    $maxSize = 2 * 1024 * 1024;
                    // On teste si le format correspond, la taille du fichier
                    if (!array_key_exists($ext, $type)) {
                        $erreur = "Le format du fichier est incorrect !";
                        // Si le fichier est trop lourd
                    } elseif ($files[$field]['size'] > $maxSize) {
                        $erreur = "Le fichier est trop volumineux !";
                    }
                } else {
                    $erreur = "Le type et/ou le format du document n'est pas valide !";
                }
            } else {
                // Si $_Files est > 0, on affiche l'erreur correspondante
                $erreur = $files[$field]['error'];
            }
        }
        return $erreur;
    }

    
    /**
     * Méthode qui formate le fichier avant stockage
     * @param array $files Méthode d'envoi
     * @param array $fields fichier à formater
     * 
     * @return string $file nouveau nom de fichier formaté
     */
    public static function formateFile(array $files, array $fields): string 
    {
        // Parcours chaque champs
        foreach ($fields as $field) {
            // Formate le fichier
            $uniqueName = uniqid('', true);
            $file = $uniqueName . "." . pathinfo($files[$field]['name'], PATHINFO_EXTENSION);
        }
        return $file;
    }  


     /**
     * 
     * Permet le redimensionnement des images dans 3 formats
     * afin de l'adapter pour le RWD
     * 
     * @param string [$path] Chemin du fichier
     * @param int [$w] Largeur de redimensionnement de l'image voulu
     * @param int [$h] Hauteur de redimensionnement de l'image voulu
     * 
     * @return string [$destination] Retourne le chemin de l'image redimensionnée
     */
    private function imageSize($path, $w, $h): string
    {
        // Récupère l'extension, et le nom du fichier
        $ext =  pathinfo($path, PATHINFO_EXTENSION);
        $name = pathinfo($path, PATHINFO_FILENAME);
        // Crée le chemin du fichier
        $destination =  'img/'. $name . '.webp';

        // Déplace le fichier dans le dossier correspondant s'il n'est pas présent
        if (file_exists( $destination)) {

            $_SESSION['error'] = $name . '.webp' . " déja existant !";
        } else {

            move_uploaded_file($_FILES['file']["tmp_name"],  'img/'. $name . '.webp');
        
            // Récupère les dimension du fichier source
            $size = getimagesize($destination);
            $width = $size[0];
            $height = $size[1];
        
            // Array permettant d'appeler la bonne méthode selon l'extension
            // afin de stocker le format d'image
            $handler = array(
                    'jpg' => 'imagecreatefromjpeg', 'png' => 'imagecreatefrompng', 'webp' => 'imagecreatefromwebp', 'jpeg' => 'imagecreatefromjpeg',
                    'new' => array('jpg' => 'imagejpeg', 'png' => 'imagepng', 'webp' => 'imagewebp', 'jpeg' => 'imagejpeg') );

            //Appel la bonne méthode imagecreatefrom**
            $image = $handler[$ext]($destination);

            // Créer une image de fond par default
            $new_image = imagecreatetruecolor($w, $h);
            // Créer la copie de l'image
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $w, $h, $width, $height);
            // Créer l'image dans le format voulu
            // en appelant la bonne méthode image**
            $handler['new'][$ext]($new_image, $destination, 9);
        
            // Détruit l'image source de la mémoire
            imagedestroy($new_image);
        }
        return  $destination;
    }
}