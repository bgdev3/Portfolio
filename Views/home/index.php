                                                    <!-- Vue de la page d'accueil -->
<?php

session_start();
$title = 'Accueil';

// Si l'admin est connecté, on supprime ses données
if(isset($_SESSION['username_admin'])) {
    unset($_SESSION['username_admin']);
    unset($_SESSION['id_admin']); 
}
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
            <a href="https://www.bgdev.fr/public/img/cv.pdf" target="_blank">Télécharger cv</a>
        </div>
        
        <p class="text-style">
            <span></span><br>Après 16 ans d'activité dans le domaine médical,  je me suis reconverti dans le développement web afin de rallier passion et monde professionnel.<br><br> 
                Diplômé d'une formation certifiante de niveau V de développeur web et web mobile, je suis à l'écoute et étudie toutes les possibilités de projets pour lesquels nous pourrions travailler ensemble. En effet, mon expérience acquise me permet de répondre au mieux à vos différents besoins et de vous proposer les solutions les plus adéquates à vos attentes.<br><br>
                D'un site vitrine à un projet plus complexe, je vous ferai part de la meilleure expertise possible afin d'évoluer dans les conditions les plus optimales. Alors, à très vite …
        </p>
        <a href="/public/productions">Portfolio</a>  
    </div>
   
</section>