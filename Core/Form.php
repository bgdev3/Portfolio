<?php
namespace Portfolio\Core;

/**
 * Class qui permet la vérification des différents champs de formulaires, des uploads, du formatge des fichiers stockés
 */
class Form 
{
    
     /**
     * Vérifie que les données du formulaire ne sont pas vides.
     * 
     * @param array $post methode d'envoi envoyé par le formulaire
     * @param array fields Données envoyées par le formulaire
     * 
     * @return bool
     */
    public static function validatePost(array $post, array $fields): bool
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
    public static function validateFiles(array $files, array $fields): bool  
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
    public static function errorUpload(array $files, array $fields, array $type): string 
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
    public static function formateFileAdmin(array $files, array $fields): mixed
    {
        $data = [];
        // Parcours chaque champs
        foreach ($fields as $field) {
           
            // Formate le fichier
            $uniqueName = uniqid('', true);
            $filename =  $uniqueName . "." . pathinfo($files[$field]['name'], PATHINFO_EXTENSION);
            array_push($data, $filename);
        }

      
            return $data;
       
        // return $filename;
    }
    
     
    /**
     * Méthode qui formate le fichier avant stockage
     * @param array $files Méthode d'envoi
     * @param array $fields fichier à formater
     * 
     * @return string $file nouveau nom de fichier formaté
     */
    public static function formateFileCv(array $files, array $fields): mixed
    {
        // $data = [];
        // Parcours chaque champs
        foreach ($fields as $field) {
           
            // Formate le fichier
            $uniqueName = uniqid('', true);
            $filename =  $uniqueName . "." . pathinfo($files[$field]['name'], PATHINFO_EXTENSION);
            // array_push($data, $filename);
        }

      
            return $filename;
       
        // return $filename;
    }
    

}