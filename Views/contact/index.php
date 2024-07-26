<?php
$title = 'Contact';
?>

<section>
    <div  class="form-contact">
        <h1>Contact</h1>
        
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
                    <input type="text" id="phone" name="phone" class="inputForm" required>
                </div>

                <div>
                    <label for="obj">Object*</label>
                    <input type="text" id="obj" name="obj" class="inputForm" required>

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