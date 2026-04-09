/**
 * Permet de vérifier le token re-Captcha passé en post dans les formulaires
 */
function loadRecaptchaToken() {
    
    const key = document.querySelector('meta[name="recaptcha-key"]').content;
    grecaptcha.ready(function () {
        grecaptcha.execute(key, { action: 'myForm' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
}


// Exporte la fonction 
 export function loadRecaptcha() {
    if(document.querySelector('#myForm')) {
        loadRecaptchaToken();
        setInterval(function(){loadRecaptchaToken();}, 100000);
    }
   
}