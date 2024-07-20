<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/878534cf28.js" crossorigin="anonymous"></script>
    <!-- inclut la feuille de style -->
    <link rel="stylesheet"  href="sass/style.css">
    <title>Portfolio</title>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Portfolio</h1>
            <nav>
                <ul class="nav-header">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Productions</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </header>
        <main><?= $content ?></main>
        <footer>
            <ul>
                <!-- facebook -->
                <li><a href="https://www.facebook.com/boo.ka.5"><i class="fa-brands fa-facebook-f"></i></a></li>
                <!-- LinkedIn -->
                <li><a href="www.linkedin.com/in/guillaume-boukehaili-919656238"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <!-- Github -->
                <li><a href="github.com/charlieGui"><i class="fa-brands fa-github"></i></a></li>
            </ul>
        </footer>
    </div>   
</body>
</html>