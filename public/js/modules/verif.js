/**
 * Exporte la fonction 
 * 
 * Vérification de formulaire 
 */
export function verif() {
//    Récupère les éléments
    let btnSend = document.querySelectorAll('#btnSend');
    let agree =  document.getElementById('agree');
    let validationCheck = document.querySelector('input + small');

    /**
     * 
     * @param {event} e capture l'évènement
     */
     function validateForm(e) {
        
        // Capture l'évènement
        e.preventDefault();
        const chps = document.querySelectorAll('[required]');
        let valid = true;
      
        // Sur chaque champs au focus un supprime l'erreur
        chps.forEach(el =>{
            el.addEventListener('focus', ()=>{
                reset();
                el.classList.remove('error');
            });
            // A chaque sorti du champs, nouvelle vérification de validité
            el.addEventListener('blur', ()=>{
                validation(el);
            });
        });
        // Sur chaque champs, si la validité n'est pas bonne
        // le booléen est mis à false
        chps.forEach( el => {
            if(!validation(el))
                valid = false;
        });
        //  Si false, on s'assure qu'un span n'est pas déja présent puis il est créé
        if(!valid) {
            reset();
            let span = document.createElement('span');
            span.innerHTML = "Veuillez remplir correctement les champs.";
            span.classList.add('msgError');
            document.querySelector('#myForm').before(span);
        } else {
            // Sinon on nettoie les spans d'erreur et soumission du formulaire
            reset();
            document.getElementById('myForm').submit();   
        }
     }

     /**
      * Effectue une validité des données par l'API HTML5
      * 
      * @param {*} ch champ parcouru
      * @returns 
      */
     function validation(ch) {
        // Si le champs est valide, assigne la classe css et return true
        if (ch.checkValidity()) {
            ch.classList.add('validate');
            // if(agree != null)
            return true;
        } else {
            // Sinon assigne la classe css correspondante
            ch.classList.add('error');
            // if(agree != null)
            validationCheck.classList.add('errorCheck');
           return false;
        
        }
     }


     /**
      * Effectue un reset des span d'erreur
      */
     function reset(){
        let span = document.querySelector('span.msgError');
        if(span !== null)
            span.remove();
     }

    // Sur chaqeu bouton de soumission des formulaires récupérés, s' il est présent, applique l'ecouteur d'évènement.
    btnSend.forEach(btn=>{
        btn == null ?  btn == 'undefined' : btn.addEventListener('click', validateForm);
    });
}