<?php
$title = 'Contact';
?>

<section>
    <div  class="form-contact">
        <h1>Contact</h1>
        
        <form action="" method="POST" novalidate>
        <small>(*)Champs obligatoire</small>
            <div class="flex-form">
                <div>
                    <label for="name">Nom*:</label>
                    <input type="text" id="name" name="name" required>
                
                    <label for="surname">Prénom*:</label>
                    <input type="text" id="surname" name="surname" required>
                
                    <label for="email">Email*:</label>
                    <input type="email" id="email" name="email" required>
                
                    <label for="phone">Téléphone*:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div>
                    <label for="obj">Object*</label>
                    <input type="text" id="obj" name="obj" required>

                    <label for="message">Message*</label>
                    <textarea id="message" name="message" rows="8" required></textarea>
                
                </div>
            </div>
        
            <input type="submit" class="btn" value="Envoyer">
        
        
        </form>
    </div>
   
</section>