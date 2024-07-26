export function verif() {
   
    let btnSend = document.getElementById('btnSend');
    let agree =  document.getElementById('agree');
        let validationCheck = document.querySelector('input + small');
        console.log(validationCheck);
     function validateForm(e){
        const chps = document.querySelectorAll('[required]');
        
        console.log(chps);
        e.preventDefault();

        let valid = true;

        chps.forEach(el =>{
            el.addEventListener('focus', ()=>{
                reset();
                el.classList.remove('error');
            });
            el.addEventListener('blur', ()=>{
                validation(el);
            });
        });
        chps.forEach( el => {
            if(!validation(el))
                valid = false;
        });

        if(!valid) {
            reset();
            let span = document.createElement('span');
            span.innerHTML = "Veuillez remplir correctement les champs.";
            span.classList.add('msgError');
            document.querySelector('#myForm').before(span);
        } else {
            reset();
            document.getElementById('myForm').submit();   
        }
     }

     function validation(ch) {
        if (ch.checkValidity()) {
            ch.classList.add('validate');
            if(agree != null)
            //   validationCheck.classList.add('validateCheck');
            return true;
        }
        else {
            ch.classList.add('error');
            if(agree != null)
            validationCheck.classList.add('errorCheck');
           return false;
        
        }
     }

     function reset(){
        let span = document.querySelector('span.msgError');
        if(span !== null)
            span.remove();
     }

     btnSend.addEventListener('click', validateForm);
}