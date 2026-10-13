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

$base = "www.bgdev.fr/public/";
$profile = $data_profile[0] ?? null;

$url   = !empty($profile->pathCv) ? $base . $profile->pathCv : '';
$photo = !empty($profile->profile) ? $profile->profile : '';
?>

<section>
    <div class="presentation">
        <div class="name-style">
           <?php if ($photo !== ''): ?>
                <img src="<?php echo $photo; ?>" alt="Guillaume Boukehaili, developpeur web" class="profile-pic">
            <?php endif; ?>

            <h1>
                <p >Guillaume<Br><span class="name">Boukehaili</span></p>
                <div class="dev"> 
                    <span class="work">Développeur<span> web</span></span>
                    <span >PHP / Symfony &middot; Freelance </span>
                </div>
           </h1>
            
            
            <div class="actions">
                <a href="/public/productions" title="Portfolio">Portfolio</a>  
                <a href="/public/contact" title="contact">Me contacter</a>
                <a href=<?php echo $url;?> target="_blank" title="cv">Télécharger cv</a>
                   
            </div>
            
        </div>
        
        <div class="flex_presentation">

       
                <section class="text-style">
                    <span></span><br>Développeur web freelance PHP / Symfony, je conçois des sites et applications sur mesure : sites vitrines, e-commerce WordPress/WooCommerce, outils métier.<br><br>
                                    Après 16 ans dans le secteur médical, j’ai gardé de ce métier la rigueur, le sang-froid et le sens du service. Je les applique à chaque projet : un besoin bien cadré, un code propre, des délais tenus.<br><br>
                                    Titulaire d’un titre de niveau V de développeur web et web mobile, je travaille avec des TPE, artisans et commerçants, de l’idée à la mise en ligne.
                                    <p >
                    <a href="/public/productions" title="Mes projets" class=""> Voir mes projets</a>
                    <a href="/public/contact" title="Contact"> Me contacter</a>
                </p>
                </section>
                
           </div>
    </div>
</section>