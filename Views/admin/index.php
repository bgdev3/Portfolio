<?php
$title = 'Admin - connexion';
$token = isset($_SESSION['token']) ? trim($_SESSION['token']) : null ;

?>

<section>

    <div class="form-connect">
        <?php if(!empty($error)) {
            echo $error;
        }
        ?>
        <h1 class="section-title">Connexion</h1>
        <form action="" method="POST" id="myForm" novalidate>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="inputForm" required>
            <label for="password">Password</label>
            <input type="text" id="password" name="password" class="inputForm" required>
            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <input type="submit" id="btnSend" name="btnSend" value="Connexion" class="btnForm" >
        </form>
    </div>
    
</section>