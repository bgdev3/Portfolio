                                            <!-- Vue de la page contact -->
<?php
$title = 'Contact';
?>

<section>
    <div  class="form-contact">
        <h1 class="section-title">Contact</h1>
        <!-- Affiche le message d'erreur s'il y en a un-->
        <?php if (!empty($error)) { ?>

            <div class="errorForm">  <?php echo $error; ?> </div>
       
        <?php } ?>

        <form action="" method="POST" id="myForm" novalidate>
            <small>(*)Champs obligatoire</small>
            <div class="flex-form">
                <div>
                    <label for="name">Nom*:</label>
                    <input type="text" id="name" name="name" class="inputForm" required>
                
                    <label for="surname">Prénom*:</label>
                    <input type="text" id="surname" name="surname" class="inputForm" required>
                
                    <label for="email">Email*:</label>
                    <input type="email" id="email" name="email"  class="inputForm" required>
                
                    <label for="phone">Téléphone*:</label>
                    <input type="tel" id="phone" name="phone" minlength='10', maxlength='10' class="inputForm" required>
                </div>

                <div>
                    <label for="object">Object*</label>
                    <input type="text" id="object" name="object" class="inputForm" required>

                    <label for="message">Message*</label>
                    <textarea id="message" name="message" rows="9" class="inputForm"  required></textarea>
                </div>
            </div>
            
            <div>
                <input type="checkbox" id="agree" required>
                <small>J'ai lu et accepte la politique de confidentialité et les mentions légales.</small>
                <input type="submit" id="btnSend" class="btnForm" value="Envoyer">
            </div>
        </form>
    </div>
   
</section>