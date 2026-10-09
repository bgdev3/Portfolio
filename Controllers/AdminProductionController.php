<?php
namespace Portfolio\Controllers;

use Portfolio\Entities\Production;
use Portfolio\Entities\Template;
use Portfolio\Models\ProductionModel;
use Portfolio\Models\TemplateModel;
use Portfolio\Services\Captcha;
use Portfolio\Services\Form;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AdminProductionController extends Controller
{

    public function __construct (
            private readonly Form $form,
            private readonly Captcha $captcha,
            private readonly TemplateModel $templateModel,
            private readonly ProductionModel $productionModel,
            private readonly Template $template,
            private readonly Production $production
        ){}

    /**
     * Récupère les différentes réalisations stockées
     */
    public function index(): void{
        
        /**@var  ProductionModel $model */
        
        $list = $this->productionModel->findAll();
        
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
        $error = '';
        $captcha = false;
        $paths =[]; $arrayFiles = []; 
        $nb = 1;
        unset($_SESSION['error']);
    
        // Si les champs POST et FILES ne sont pas vides
        if ($this->form->validatePost($_POST, ['title', 'url', 'description', 'createdAt', 'comment']) && $this->form->validateFiles($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4'])) {
            // Type de fichier uploadé acceptés
            $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
            // Si un erreur est déclarée sur un des fichier uploadés
            $error = empty($erreur) ? $this->form->errorUpload($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4'], $type) : "" ;
            // Formate les noms de fichier sformatés dans un array 
            $files = $this->form->formateFileAdmin($_FILES, ['file', 'tmp1', 'tmp2', 'tmp3', 'tmp4']);

            $arrayFiles =  [1 => 'file', 2 => 'tmp1', 3=> 'tmp2', 4 =>  'tmp3', 5 => 'tmp4'];

            // Si les tokens correspondent afin de contrer une faille CSRF
            if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
                // Instance du reCpatcha
                // $captcha = new Captcha();

                // si la clé en post de vérifiaction du captcha est déclaré
                // if (isset($_POST['recaptcha_response']))
                //     $captcha = $this->captcha->verify($_POST['recaptcha_response']);
                
                // Si la reponse du captcha est valide
                // if ($captcha == true) {
                    // Si l'erreur est vide
                    if (empty($error)) {
                        // Boucle sur chaque fichier image  récupérés
                       foreach ($files as $i => $file) {
                            $key = $arrayFiles[$nb];                 // 'file', 'tmp1', ...
                            $tmpPath = $_FILES[$key]['tmp_name'];    // chemin temporaire réel

                            $path = $this->imageSize($file, $tmpPath, 500, 500);
                            if ($path === '') {
                                break; // erreur déjà stockée dans $_SESSION['error']
                            }
                            $nb++;
                            $paths[] = $path;
                        }
                    
                        // Si l'image est uploadé et déplacé
                        if (empty($_SESSION['error'])) {
        
                            // hydrate entité
                            // $production = new Producion();
                            $this->production->setTitle( htmlspecialchars($_POST['title'], ENT_QUOTES) );
                            $this->production->setUrl( htmlspecialchars($_POST['url'], ENT_QUOTES) );
                            $this->production->setDescription( htmlspecialchars($_POST['description'], ENT_QUOTES) );
                            $this->production->setPath($paths[0]);
                            $this->production->setCreatedAt( htmlspecialchars($_POST['createdAt'], ENT_QUOTES) );
                            $this->production->setSass( isset($_POST['sass']) ? $_POST['sass'] : null );
                            $this->production->setBootstrap( isset($_POST['boot']) ? $_POST['boot'] : null );
                            $this->production->setTailwind( isset($_POST['tail']) ? $_POST['tail'] : null );
                            $this->production->setJs( isset($_POST['js']) ? $_POST['js'] : null );
                            $this->production->setDocker( isset($_POST['dock']) ? $_POST['dock'] : null );
                            $this->production->setPhp( isset($_POST['php']) ? $_POST['php'] : null );
                            $this->production->setSymfony( isset($_POST['symfony']) ? $_POST['symfony'] : null );
                            $this->production->setWordpress( isset($_POST['wp']) ? $_POST['wp'] : null );
                            $this->production->setIdUser($_SESSION['id_admin']);
                            // Crée l'enregistrement
                            // $productionModel = new ProductionModel();
                            $this->productionModel->create($this->production);

                            // Récupère le dernier enregistrement de la table afin de récupérer
                            // l'id pour hydratrer la clé étrangère
                            $prod = $this->productionModel->findLast();

                            // $template = new Template();
                            $this->template->setPath1($paths[1]);
                            $this->template->setPath2($paths[2]);
                            $this->template->setPath3($paths[3]);
                            $this->template->setPath4($paths[4]);
                            $this->template->setComments( isset($_POST['comment']) ? $_POST['comment'] : null );
                            $this->template->setIdProduction($prod->idProduction);
                            // Crée l'enregistrement des templates relatifs à la production
                            $this->templateModel->create($this->template);
                    
                        } else {
                            $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                        }   
                    } 
                // } else {
                //     $error = "Le reCaptcha n'est pas valide";
                // }
            } else {
                // Sinon redirige directement vers l'index en supprimant les données de connexion
                session_unset();
                session_destroy();
                header('location:/public/');
                exit();
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
         $error = '';
         $captcha = false;
         $arrayFiles =  ['file','tmp1', 'tmp2',  'tmp3',  'tmp4'];
         $nb = 0;
         unset($_SESSION['error']);

        // Si les champs ne sont pas vides
        if ($this->form->validatePost($_POST, ['title', 'url', 'description', 'createdAt', 'comment'])) {

             // Instance du reCpatcha
            //  $captcha = new Captcha();

             // si la clé en post de vérifiaction du captcha est déclaré
            //  if (isset($_POST['recaptcha_response']))
            //      $captcha = $this->captcha->verify($_POST['recaptcha_response']);
             
             // Si la reponse du captcha est valide
            //  if ($captcha == true) {
                // Si les tokens correspondent afin d'éviter une faille XSS
                if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {

                    // Hydrate l'entité
                    // $production = new Production();
                    // $template = new Template();

                    $this->production->setTitle(htmlspecialchars($_POST['title'], ENT_QUOTES));
                    $this->production->setUrl(htmlspecialchars($_POST['url'], ENT_QUOTES));
                    $this->production->setDescription(htmlspecialchars($_POST['description'], ENT_QUOTES));
                    $this->production->setCreatedAt(htmlspecialchars($_POST['createdAt'], ENT_QUOTES));
                    $this->production->setSass( isset($_POST['sass']) ? $_POST['sass'] : null );
                    $this->production->setBootstrap( isset($_POST['boot']) ? $_POST['boot'] : null );
                    $this->production->setTailwind( isset($_POST['tail']) ? $_POST['tail'] : null );
                    $this->production->setJs( isset($_POST['js']) ? $_POST['js'] : null );
                    $this->production->setDocker( isset($_POST['dock']) ? $_POST['dock'] : null );
                    $this->production->setPhp( isset($_POST['php']) ? $_POST['php'] : null );
                    $this->production->setSymfony( isset($_POST['symfony']) ? $_POST['symfony'] : null );
                    $this->production->setWordpress( isset($_POST['wp']) ? $_POST['wp'] : null );
                    $this->production->setIdUser($_SESSION['id_admin']);

                    // Format de fichier acceptés
                    $type = array('jpg'=>'image/jpg', 'jpeg'=>'image/jpeg', 'webp'=>'image/webp', 'png'=>'image/png');
                    
                    // Pour chaque nom de fichier stockés
                    foreach($arrayFiles as $file) {
                        
                        $setPath = "setPath" . $nb;      // Créer le setter avec le nb d'occurence
                        $hiddenPath = "hidden_" . $file; // Créer le nom de fichier hidden 

                        // Si le fichier ne presente pas d'erreur d'envoi
                        if ($this->form->validateFiles($_FILES,  [$file])) {

                            // Vérifie le bon fomrat, la taille et l'extension du fichier
                            $error = empty($erreur) ? $this->form->errorUpload($_FILES, [$file], $type) : "" ;
                            // Formate le fichier
                            $fileItem = $this->form->formateFileAdmin($_FILES, [$file]);
                            // Redimensionne l'image avant de l'uploader sur le serveur
                            $file = $this->imageSize($_FILES[$arrayFiles[$nb]]['name'], $_FILES[$arrayFiles[$nb]]['tmp_name'], 457, 475);
                            
                            // Si le redimensionnement s'est bien dértoulé
                            if (empty($_SESSION['error'])) {

                                // $nb vaut 0 ? Hydrate l'entité Production, sinan hdrate l'entité Template
                                $nb == 0 ? $this->production->setPath($file) :  $this->template->$setPath($file);
                                
                            // Sinon assigne l'erreur
                            } else {
                                $error =  !empty($_SESSION['error']) ? $_SESSION['error'] : '';
                            }
                        // Sinon hydrate par default les hiddens récupérés en post des chemins stockés en bdd
                        } else {
                            $nb == 0 ? $this->production->setPath($_POST[$hiddenPath]) :  $this->template->$setPath($_POST[$hiddenPath]);
                        }
                        ++$nb;
                    } 
                    $this->template->setComments( isset($_POST['comment']) ? $_POST['comment'] : null );
                    // Mise à jour de la bdd
                    // $productionModel = new ProductionModel();
                    // $templateModel = new TemplateModel();

                    $this->productionModel->update($id, $this->production);
                    $this->templateModel->update($this->template, $id);
                
                    header('location:/public/adminProduction');
                    exit();
                } else {
                    // Sinon redirige directement vers l'index en supprimant les données de connexion
                    session_unset();
                    session_destroy();
                    header('location:/public/');
                    exit();
                }
            // } else {
            //     $error = "Le reCaptcha n'est pas valide";
            // }
           
           
        } else {
            $error = (!empty($_POST)) ? 'Merci de remplir correctment les champs' : '';
        }

        // Récupère l'enregistrement correspondant par l'id afin d'afficher dans le formulaire
        if (isset($id) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            // $model = new ProductionModel();
            $production = $this->productionModel->join($id);
            // Récupère le premier élement de la jointure (qui sera toujours unique ici)
            $production = $production[0];
            
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
            // $model = new ProductionModel();
            $this->productionModel->delete($id);
            // Renvoi vers la liste des réalisations
            header('location:/public/adminProduction');
            exit();
        // Si no est déclaré, redirige vers la liste des réalisations
        } elseif(isset($_POST['no']) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
            header('location:/public/adminProduction');
            exit();
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
     * @param int $w Largeur de redimensionnement de l'image voulu
     * @param int $h Hauteur de redimensionnement de l'image voulu
     * 
     * @return string [$destination] Retourne le chemin de l'image redimensionnée
     */
   protected function imageSize(string $originalName, string $tmpPath, int $w, int $h): string
    {
        // Type réel du fichier, pas celui annoncé par le navigateur
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmpPath);

        $loaders = [
            'image/jpeg' => 'imagecreatefromjpeg',
            'image/png'  => 'imagecreatefrompng',
            'image/webp' => 'imagecreatefromwebp',
        ];

        if (!isset($loaders[$mime])) {
            $_SESSION['error'] = 'Format non supporté (jpg, png, webp uniquement)';
            return '';
        }

        // Nettoyage du nom : accents, espaces, apostrophes
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $name = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
        if ($name === '') {
            $name = 'image-' . uniqid();
        }

        $destination = 'img/' . $name . '.webp';

        if (file_exists($destination)) {
            $_SESSION['error'] = $name . '.webp déjà existant !';
            return '';
        }

        $source = $loaders[$mime]($tmpPath);

        $newImage = imagecreatetruecolor($w, $h);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $w, $h, imagesx($source), imagesy($source));
        imagewebp($newImage, $destination, 80);


        return $destination;
    }
}