                                                        <!-- Vue d'une nouvelle production -->
 <?php
$title = 'Admin - Ajout';
$token = isset($_SESSION['token']) ? trim($_SESSION['token']) : null;
if(!isset($_SESSION['username_admin']))
    header('location:index.php');
?>

<section >
   
    <div class="form-admin">

        <h1 class="section-title">Nouvelle réalisation</h1>
        <?php if (!empty($error)) { ?>

            <div class="msgError"> <?php echo $error; ?> </div>

        <?php } ?>
        <form action="" method="POST" id="myForm" enctype="multipart/form-data" novalidate>
        
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" class="inputForm" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" class="inputForm" rows="8" required></textarea>
            <label for="createdAt">Date de création</label>
            <input type="date" id="createdAt" name="createdAt" class="inputForm" required>
            <label for="file">Fichier</label>
            <input type="file" id="file" name="file" class="inputForm">
            <div>
                <input type="checkbox" id="html" name="html" value="fa-brands fa-html5">
                <label for="html">HTML5</label>
                <input type="checkbox" id="sass" name="sass" value="fa-brands fa-sass">
                <label for="sass">Sass</label>
                <input type="checkbox" id="js" name="js" value="fa-brands fa-square-js">
                <label for="js">JS Vanilla</label>
                <input type="checkbox" id="php" name="php" value="fa-brands fa-php">
                <label for="php">PHP</label>
                <input type="checkbox" id="symfony" name="symfony" value="fa-brands fa-symfony">
                <label for="symfony">Symfony</label>
                <input type="checkbox" id="react" name="react" value="fa-brands fa-react">
                <label for="react">React</label>
                <input type="checkbox" id="wp" name="wp" value="fa-brands fa-wordpress-simple">
                <label for="wordpress">Wordpress</label>
            </div>
           
            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">
 
        </form>
    </div>
</section>