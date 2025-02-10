                                                        <!-- Vue d'une nouvelle production -->
<?php
$title = 'Admin - Ajout';
$token = isset($_SESSION['token']) ? trim($_SESSION['token']) : null;
if(!isset($_SESSION['username_admin']))
    header('location:/public/');
?>

<section >
   
    <div class="form-admin">

        <h1 class="section-title">Nouvelle réalisation</h1>
        <?php if (!empty($error)) { ?>

            <div class="msgError"> <?php echo $error; ?> </div>

        <?php } ?>
        <form action="" method="POST" id="myForm" enctype="multipart/form-data" novalidate>
           <div class="flex-form">

                <div>
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="inputForm" required>
                    <label for="createdAt">Date de création</label>
                    <input type="date" id="createdAt" name="createdAt" class="inputForm" required>
                    <label for="file">Screenshot</label>
                    <input type="file" id="file" name="file" class="inputForm">
                    <label for="url">URL</label>
                    <input type="text" id="url" name="url" class="inputForm" required>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="inputForm" rows="8" required></textarea>
                </div>
         
                <div>
                    <label for="tmp1">Template 1</label>
                    <input type="file" id="tmp1" name="tmp1" class="inputForm" required>
                    <label for="tmp2">Template 2</label>
                    <input type="file" id="tmp2" name="tmp2" class="inputForm" required>
                    <label for="tmp3">Template 3</label>
                    <input type="file" id="tmp3" name="tmp3" class="inputForm" required>
                    <label for="tmp4">Template 4</label>
                    <input type="file" id="tmp4" name="tmp4" class="inputForm" required>
                    <label for="comment">Commentaire client</label>
                    <textarea id="comment" name="comment" class="inputForm" rows="8"></textarea>
                </div>
            </div>
            
            <div class="langages">
                <div>
                    <input type="checkbox" id="html" name="html" value="fa-brands fa-html5">
                    <label for="html">HTML5</label>
                </div>
                <div>
                    <input type="checkbox" id="sass" name="sass" value="fa-brands fa-sass">
                    <label for="sass">Sass</label>
                </div>
                <div>
                    <input type="checkbox" id="boot" name="boot" value="fa-brands fa-bootstrap">
                    <label for="boot">Bootstrap</label>
                </div>
                <div>
                    <input type="checkbox" id="js" name="js" value="fa-brands fa-square-js">
                    <label for="js">JS Vanilla</label>
                </div>
                <div>
                    <input type="checkbox" id="php" name="php" value="fa-brands fa-php">
                    <label for="php">PHP</label>
                </div>
                    <div> <input type="checkbox" id="symfony" name="symfony" value="fa-brands fa-symfony">
                    <label for="symfony">Symfony</label></div>
                <div>
                    <input type="checkbox" id="react" name="react" value="fa-brands fa-react">
                    <label for="react">React</label>
                </div>
                <div>
                    <input type="checkbox" id="wp" name="wp" value="fa-brands fa-wordpress-simple">
                    <label for="wordpress">Wordpress</label>
                </div>   
            </div>

            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">
 
        </form>
    </div>
</section>

<!-- Appel du script Re-captcha -->
<script src="https://www.google.com/recaptcha/api.js?render=6LdBCjUqAAAAAOJSNtjby8x8H2HSBVUBfaic0jJs"></script>