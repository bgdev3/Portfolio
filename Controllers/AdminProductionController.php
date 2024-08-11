<?php
namespace Portfolio\Controllers;

use Portfolio\Entities\Production;
use Portfolio\Models\ProductionModel;
use Portfolio\Core\Form;

session_start();

class AdminProductionController extends Controller
{

    
    /**
     * Récupère les différentes réalisations stockées
     */
    public function index(): void{
        
        /**@var  */
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
    public function add($token): void
    {
        global $error;
        // Si les champs POST et FILES ne sont pas vides
        if (Form::validatePost($_POST, ['title', 'description', 'createdAt']) && Form::validateFiles($_FILES, ['file'])) {
            // Type de fichier uploadé acceptés
            $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
            // S'il y à une erreur elle est récupéré
            $error = empty($erreur) ? Form::errorUpload($_FILES, ['file'], $type) : "" ;
            // Formate le nom de fichier stocké dans un fichier séparé
            $file = Form::formateFile($_FILES, ['file']);
            // Si les tokens correspondent afin de contrer une faille CSRF
            if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
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
                        $production->setHtml( isset($_POST['html']) ? $_POST['html'] : null );
                        $production->setSass( isset($_POST['sass']) ? $_POST['sass'] : null );
                        $production->setJs( isset($_POST['js']) ? $_POST['js'] : null );
                        $production->setPhp( isset($_POST['php']) ? $_POST['php'] : null );
                        $production->setSymfony( isset($_POST['symfony']) ? $_POST['symfony'] : null );
                        $production->setReact( isset($_POST['react']) ? $_POST['react'] : null );
                        $production->setWordpress( isset($_POST['wp']) ? $_POST['wp'] : null );
                        $production->setIdUser($_SESSION['id_admin']);
                        
                        $productionModel = new ProductionModel();
                        $productionModel->create($production);
                
                    } else {
                        $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                    }   
                } 
            } else {
                // Sinon redirige directement vers l'index en supprimant les données de connexion
                session_unset();
                session_destroy();
                header('location:index.php');
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
    public function update(int $id, string $token): void
    {
        global $error;
        // Si les champs ne sont pas vides
        if (Form::validatePost($_POST, ['title', 'description', 'createdAt', 'hidden'])) {
            // Si les tokens correspondent afin d'éviter une faille XSS
            if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
                 // Hydrate l'entité
                $production = new Production();
                $production->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES));
                $production->setDescription(htmlspecialchars($_POST['description'], ENT_QUOTES));
                $production->setCreatedAt(htmlspecialchars($_POST['createdAt'], ENT_QUOTES));
                $production->setIdUser(1);

                // Si l'image ets valide
                if(Form::validateFiles($_FILES, ['file'])) {
                    // Type de fichier uploadé acceptés
                    $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
                    // S'il y à une erreur elle est récupéré
                    $error = empty($erreur) ? Form::errorUpload($_FILES, ['file'], $type) : "" ;
                    // Formate le nom de fichier stocké dans un fichier séparé
                    $file = Form::formateFile($_FILES, ['file']);
                    
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
                header('location:index.php?controller=adminProduction&action=index');
            } else {
                // Sinon redirige directement vers l'index en supprimant les données de connexion
                session_unset();
                session_destroy();
                header('location:index.php');
            }
           
        } else {
            $error = (!empty($_POST)) ? 'Merci de remplir correctment les champs' : '';
        }
        // Récupère l'enregistrement correspondant par l'id
        if (isset($id) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
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
    public function delete(int $id, string $token): void
    {
        // Si yes, l'id et le token sont déclarés et que les tokens correspondent
        if(isset($_POST['yes']) && isset($id) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            // Supression de la réalisation sélectionné
            $model = new ProductionModel();
            $model->delete($id);
            // Renvoi vers la liste des réalisations
            header('location:index.php?controller=adminProduction&action=index');
        // Si no est déclaré, redirige vers la liste des réalisations
        } elseif(isset($_POST['no']) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            header('location:index.php?controller=adminProduction&action=index');
        // sinon renvoi vers la confirmation de suppression d'une réalisation
        } else {
            $this->render('admin/productions/confirmDelete');
        }    
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
            $handler['new'][$ext]($new_image, $destination, 100);
        
            // Détruit l'image source de la mémoire
            imagedestroy($new_image);
        }
        return  $destination;
    }
}