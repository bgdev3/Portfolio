/**
 * Exporte la fonction 
 * 
 * Permet l'activation du menu au clic en gérant les différentes classes
 */
export function burger() {
    // récupère les éléments
    let burger = document.querySelector('.header__burger');
    let nav = document.querySelector('.nav-header');
    let win = document.querySelector('html');
    
    // Si le burger est présent, au clic on active les classes
    if(burger) {
        burger.addEventListener('click', ()=>{
            burger.classList.toggle('burger');
            nav.classList.toggle('show-menu');
            win.classList.toggle('unScroll');
        })
    }
       
}