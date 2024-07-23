<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Font montserra -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/878534cf28.js" crossorigin="anonymous"></script>
    <!-- inclut la feuille de style -->
    <link rel="stylesheet"  href="sass/style.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Portfolio</h1>
            <nav>
                <ul class="nav-header">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="index.php?controller=productions&action=index">Productions</a></li>
                    <li><a href="index.php?controller=contact&action=index">Contact</a></li>
                </ul>
            </nav>
        </header>
        <main><?= $content ?></main>
        <footer class="footer">
            <ul class="social-footer">
                <!-- facebook -->
                <li><a href="https://www.facebook.com/boo.ka.5"><i class="fa-brands fa-facebook-f"></i></a></li>
                <!-- LinkedIn -->
                <li><a href="www.linkedin.com/in/guillaume-boukehaili-919656238"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <!-- Github -->
                <li><a href="github.com/charlieGui"><i class="fa-brands fa-github"></i></a></li>
            </ul>
            <div>
                <p><a href="">Mentions légales</a>  | &copy;Tous droit réservés</p>
            </div>
        </footer>
    </div>   
</body>
</html>