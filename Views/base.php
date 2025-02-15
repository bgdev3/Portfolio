<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application de présentation des projets web de BgDev">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon//apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon//favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/manifest.json">
    <!-- Font montserra -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/878534cf28.js" crossorigin="anonymous"></script>
    <!-- inclut la feuille de style -->
    <link rel="stylesheet"  href="/public/sass/style.css">
    <script  type="module" src="/public/js/main.js"></script>
    <title><?php echo $title; ?></title>
</head>

<body class="scroller">
    <header class="header">
        <h1><a href="/public/" title="Accueil">BgDev</a></h1>
        
        <?php if(!isset( $_SESSION['id_admin']))
                require_once "template_header/header_user.php"; 
            else
                require_once "template_header/header_admin.php";
        ?>
                                <!-- MENU BURGER -->
        <div class="header__burger">
            <span></span>
        </div>
    </header>
    
    <main class="content"><?= $content ?></main>
    
    <footer class="footer">
       
        <ul class="social-footer">
    
            <!-- LinkedIn -->
            <li><a href="https://www.linkedin.com/in/guillaume-boukehaili-919656238" title="Linkedin"><i class="fa-brands fa-linkedin-in"></i></a></li>
            <!-- Github -->
            <li><a href="https://github.com/charlieGui" title="Github"><i class="fa-brands fa-github"></i></a></li>
        </ul>
        <div>
            <p><a href="/public/home/mentions" title="Mentions légales">Mentions légales</a>  | &copy;Tous droit réservés - 2024  <a href="/public/admin"><i class="fa-solid fa-right-to-bracket color-link" title="Admin"></i></a></p>
        </div>
    </footer>

</body>
</html>