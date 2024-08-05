                                                    <!-- Vue de la page d'accueil -->
<?php
session_start();
$title = 'Accueil';


// if(isset($_SESSION['admin']))
// unset($_SESSION['admin']);  
// Token créé avant la page d'authentification afin qu'il soit intégrer dans le hidden du formulaire
if (!isset($_SESSION['token'])) {
    // Si le token n'existe pas, on en assigne un
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    // Enregistrement du timestamp pour identifier le moment precis de la creation du token
    $_SESSION['token_time'] = time();
} else {
    unset($_SESSION['token']);
    unset( $_SESSION['token_time']);
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    $_SESSION['token_time'] = time();
}

?>

<section>
    <div class="presentation">
        <div class="name-style">
            <p >Guillaume<Br><span class="name">Boukehaili</span></p>
            <span class="work">Développeur<span> web</span></span>
           
        </div>
        
        <p class="text-style">
            <span>Salut !</span><br> Je m'appelle guillaume et je suis ravi de vous accueillir dans mon monde&nbsp;. Après 16 ans d'activité dans le médical&nbsp;, je me suis reconvertis dans le web
            afin de rallier ma passion et le monde professionnel&nbsp;. Diplômé d'une formation certifiante d'un titre professionnel de niveau V de développeur web et web mobile&nbsp;, je suis à l'écoute et étudie toutes les possibilités de projets pour lesquels nous pourrions travailler ensemble&nbsp;.<br> Vous avez un projet en tête&nbsp;? Une refonte complète d'un site&nbsp;? Un problème technique&nbsp;? Je prends en charge aussi bien la partie front end de votre site&nbsp;, des maquettes et intégration&nbsp;, à la partie back end de votre projet jusqu'à la livraison de celui-ci&nbsp;. Un planning surchargé&nbsp;? La possibilité de venir à vous afin de vous libérer de ce stress et de vous faire évoluer dans les meilleures conditions&nbsp;. 
            <br>Ma disponibilité est mise à contribution afin de trouver les solutions les plus adéquates qui vous permettront d'évoluer comme vous l'avez toujours souhaité&nbsp;. Alors, à très vite&nbsp;...</p>
    </div>
</section>