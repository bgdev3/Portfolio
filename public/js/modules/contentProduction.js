

export function showContentProduction(){

    let btnAdd = document.querySelectorAll('button.btn-realisation');
    let body = document.querySelector('body');
    let btnClose = document.querySelectorAll('button.btn-close');
    let centers = document.querySelectorAll('.img-project .center');
    let content =  document.querySelectorAll('div.content-container');
    let contentQuote = document.querySelector('aside.quote');
    let comments = document.querySelectorAll('aside.quote p');
    let next = document.querySelector('a.quote__next');
    let prev = document.querySelector('a.quote__prev');
    let count = 0;
    

    /**
     * Affiche le contenu personnalisé aux productions
     */
    function contentProduction() {
        
        // Snippet pour rendre la transition valide sur safari mobile
        if(screen.width <= 1024) {
            centers.forEach(el => {
                el.addEventListener('touchstart', (e)=>{
                    el.classList.toggle('hoverMobile');
                })
            })
        }
                
        // Boucle sur chaque bouton voirplus, si l'index du tableau correspond à l'index du tableau content,
        // Alors applique les classes correspondante.
        btnAdd.forEach((el, index) => {
            el.addEventListener('click', ()=>{
                content.forEach((ct, iContent) => {
                    if(index == iContent) {
                        ct.classList.remove('hide-content');
                        ct.classList.add('show-content');
                        ct.classList.add('overflowRun');
                    }
                })
                // Evite le scroll du body sous le fullscreen
                body.classList.add('overflowOff');
            })
        })

        btnClose.forEach((btn, iBtn) => {
            btn.addEventListener('click', ()=>{
                content.forEach((ct, iContent) => {
                    if(iBtn == iContent) {
                        ct.classList.add('hide-content');
                        ct.classList.remove('show-content');
                        ct.classList.remove('overflowRun');
                    }
                })
                body.classList.remove('overflowOff');
            })
        })
    }
    

    /**
     * Affiche les commentaires sous forme de diapos
     */
    function showComments() {

        // Réinitialise les éléments au debut du défilement
        function reset() {
            comments.forEach(el => {
                el.classList.add('hide-content');
                el.classList.remove('show-quote');
            })

            currentDots.forEach(el => {
                el.classList.remove('active');
            })
        }
        
        // Démarre le défilement
        function start() {
            reset();
            comments[0].classList.remove('hide-content');
            // comments[0].classList.add('show-content');
            currentDots[0].classList.add('active');
        }
    
        // Affiche les éléments vers la droite
        function startRight() {
            // réinitialise
            reset();
            count++;
            // Si count est égal à la taille du tableau
            // count vaut 0
            if(count == comments.length){
                count = 0;
            }

            comments[count].classList.remove('hide-content');
            comments[0].classList.add('show-quote');
    
            if(count > 0) 
            currentDots[count - 1].classList.remove('active');
    
            currentDots[count].classList.add('active');
        }

        // Affiche les éléments vers la gauche
        function startLeft() {
            comments[count].classList.add('hide-content');
            currentDots[count].classList.remove('active');
            count--;
           
            if(count  == -1) {
                count = comments.length - 1;
            }

            comments[count].classList.remove('hide-content');
            comments[0].classList.add('show-quote');
            currentDots[count].classList.add('active');      
        }
        
        /**
         * Gère les différents slide au doigts de l'utilisdateur
         */
        function touchFinger(){
        
            if(screen.width <= 1024) {
                let distance; let touch, start=0; 
                // let between = 20;
                // Au premier point de contact
                contentQuote.addEventListener("touchstart", function(evt) {
                    // Récupère les "touches" effectuées
                    touch = evt.changedTouches[0];
                    start = touch.pageX;
                    distance = 0;
                }, {passive:true});
                // Stop l'évènement au simple clic
                contentQuote.addEventListener('touchmove', (evt)=>{
                    evt.stopPropagation();
                }, {passive:true})
                // Quand le contact s'arrête
                contentQuote.addEventListener("touchend", function(evt) {
                    touch = evt.changedTouches[0];
                    distance = touch.pageX - start;
                    // Si le slide effectué > 0, on change l'image appropriée
                    if(distance > 0){
                        startRight();
                    }else if(distance < 0){
                    startLeft();
                    }
                });
            }
        }
       
    
          // Permet au clic sur les dots le défilements des photos
    function slideDots(){
        
        for(let i = 0; i < currentDots.length; ++i){
            currentDots[i].addEventListener('click', ()=>{
               reset();
                count = i;
                if(count == comments.length - 1) {
                    count = -1;
                }
                currentDots[i].classList.add('active');
               
                comments[i].classList.remove('hide-content');
                comments[i].classList.add('show-quote');
            });
        }
    }
 
        
        /**
         * Crée les élément dots
         * @param [occ] Nombre d'occurence correspondant au nombre d'image crée
         */
        function createDots(occ) {
        // Boucle sur le nombre d'occurence
            for(let i = 0; i < occ; i++){
                let dots = document.createElement('span');
                // Ajoute la classe active uniquement au premier élément span crée
                i == 0 ? dots.setAttribute('class', 'slide__dot__item active') : dots.setAttribute('class', 'slide__dot__item');
                let dot = document.getElementById('container-dot');
                dot.appendChild(dots);     
            }
        }

            // Créer les dots
            createDots(comments.length);
            let currentDots = document.querySelectorAll('span.slide__dot__item');
            start();
            setInterval(startRight, 5000);

            next.addEventListener('click', startRight);
            prev.addEventListener('click', startLeft);
            slideDots(); touchFinger();
    }

    if(contentQuote != null)
        showComments(); 

   contentProduction(); 
  
}