<?php
namespace Portfolio\Controllers;

use Portfolio\Core\Form;
use Portfolio\Entities\Template;
use Portfolio\Entities\Production;
use Portfolio\Models\TemplateModel;
use Portfolio\Models\ProductionModel;

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
     * @var string $error Récupère les message d'erreur
     * @var array $paths Récupère les chemins de fichier
     * @var array $arrayFiles Récupère les fichier formatés
     * @var int $nb Incrémente la boucle afin de fournir le bon nom de fichier
     */
    public function add($token): void
    {
        global $error; 
        $paths =[]; $arrayFiles = [];
        $nb = 1;
    
        // Si les champs POST et FILES ne sont pas vides
        if (Form::validatePost($_POST, ['title', 'description', 'createdAt', 'comment']) && Form::validateFiles($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4'])) {
            // Type de fichier uploadé acceptés
            $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
            // Si un erreur est déclarée sur un des fichier uploadés
            $error = empty($erreur) ? Form::errorUpload($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4'], $type) : "" ;
            // Formate les noms de fichier sformatés dans un array 
            $files = Form::formateFile($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4']);

            $arrayFiles =  [1 => 'file', 2 => 'tmp1', 3=> 'tmp2', 4 =>  'tmp3', 5 => 'tmp4'];

            // Si les tokens correspondent afin de contrer une faille CSRF
            if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
                // Si l'erreur est vide
                if (empty($error)) {
                    // Boucle sur chaque fichier image  récupérés
                    foreach($files as $file){
                        // A chaque itération, reformate l ataille et l'extension de chacun
                        $file = $this->imageSize($file, $arrayFiles[$nb], 500,  500);
                        // Incrémente afin de fournir la bon name de fichier à chaque itération
                        $nb++;
                        // Stocke le chemin de fichier formater dans un array
                        array_push($paths, $file);
                    }
                   
                    // Si l'image est uploadé et déplacé
                    if (empty($_SESSION['error'])) {
    
                        // hydrate entité
                        $production = new Production();
                        $production->setTitle( htmlspecialchars($_POST['title'], ENT_QUOTES) );
                        $production->setDescription( htmlspecialchars($_POST['description'], ENT_QUOTES) );
                        $production->setPath($paths[0]);
                        $production->setCreatedAt( htmlspecialchars($_POST['createdAt'], ENT_QUOTES) );
                        $production->setHtml( isset($_POST['html']) ? $_POST['html'] : null );
                        $production->setSass( isset($_POST['sass']) ? $_POST['sass'] : null );
                        $production->setJs( isset($_POST['js']) ? $_POST['js'] : null );
                        $production->setPhp( isset($_POST['php']) ? $_POST['php'] : null );
                        $production->setSymfony( isset($_POST['symfony']) ? $_POST['symfony'] : null );
                        $production->setReact( isset($_POST['react']) ? $_POST['react'] : null );
                        $production->setWordpress( isset($_POST['wp']) ? $_POST['wp'] : null );
                        $production->setIdUser($_SESSION['id_admin']);
                        // Crée l'enregistrement
                        $productionModel = new ProductionModel();
                        $productionModel->create($production);

                        // Récupère le dernier enregistrement de la table afin de récupérer
                        // l'id pour hydratrer la clé étrangère
                        $prod = $productionModel->findLast();

                        $template = new Template();
                        $template->setPath1($paths[1]);
                        $template->setPath2($paths[2]);
                        $template->setPath3($paths[3]);
                        $template->setPath4($paths[4]);
                        $template->setComments( isset($_POST['comment']) ? $_POST['comment'] : null );
                        $template->setIdProduction($prod->idProduction);
                        // Crée l'enregistrement des templates relatifs à la production
                        $templateModel = new TemplateModel();
                        $templateModel->create($template);
                
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
        $arrayFiles =  [0 => 'file', 1 => 'tmp1', 2=> 'tmp2', 3 =>  'tmp3', 4 => 'tmp4'];
        $nb = 0;

        // Si les champs ne sont pas vides
        if (Form::validatePost($_POST, ['title', 'description', 'createdAt', 'comment'])) {

            // Si les tokens correspondent afin d'éviter une faille XSS
            if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
                 // Hydrate l'entité
                $production = new Production();
                $template = new Template();

                $production->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES));
                $production->setDescription(htmlspecialchars($_POST['description'], ENT_QUOTES));
                $production->setCreatedAt(htmlspecialchars($_POST['createdAt'], ENT_QUOTES));
                $production->setIdUser($_SESSION['id_admin']);

                // Format de fichier acceptés
                $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
                
                // Pour chaque nom de fichier stockés
                foreach($arrayFiles as $file) {
                    
                    $setPath = "setPath" . $nb;      // Créer le setter avec le nb d'occurence
                    $hiddenPath = "hidden_" . $file; // Créer le nom de fichier hidden 

                    // Si le fichier ne presente pas d'erreur d'envoi
                    if (Form::validateFiles($_FILES,  [$file])) {

                        // Vérifie le bon fomrat, la taille et l'extension du fichier
                        $error = empty($erreur) ? Form::errorUpload($_FILES, [$file], $type) : "" ;
                        // Formate le fichier
                        $fileItem = Form::formateFile($_FILES, [$file]);
                        // Redimensionne l'image avant de l'uploader sur le serveur
                        $file = $this->imageSize($fileItem[0], $arrayFiles[$nb], 500,  500);
                        
                        // Si le redimensionnement s'est bien dértoulé
                        if (empty($_SESSION['error'])) {

                            // $nb vaut 0 ? Hydrate l'entité Production, sinan hdrate l'entité Template
                            $nb == 0 ? $production->setPath($file) :  $template->$setPath($file);
                            // Hydrate les commentaires s'il y en a
                            $template->setComments( isset($_POST['comment']) ? $_POST['comment'] : null );

                        // Sinon assigne l'erreur
                        } else {
                            $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                        }
                    // Sinon hydrate par default les hiddens récupérés en post des chemins stockés en bdd
                    } else {
                        $nb == 0 ? $production->setPath($_POST[$hiddenPath]) :  $template->$setPath($_POST[$hiddenPath]);
                    }
                ++$nb;
            } 
                
            // Mise à jour de la bdd
            $productionModel = new ProductionModel();
            $templateModel = new TemplateModel();

            $productionModel->update($id, $production);
            $templateModel->update($template, $id);
        
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

        // Récupère l'enregistrement correspondant par l'id afin d'afficher dans le formulaire
        if (isset($id) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            $model = new ProductionModel();
            $production = $model->join($id);
            
            // Récupère le premier élement de la jointure (qui sera toujours unique ici)
            $production = $production[0];
            $_SESSION['test'] = $production;
        }
        // Renvois vers la vue
        $this->render('admin/productions/update', ['production' => $production, 'error' => $error]);
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
    private function imageSize($path, $tmpName, $w, $h): string
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

            move_uploaded_file($_FILES[$tmpName]['tmp_name'],  'img/'. $name . '.webp');
           
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