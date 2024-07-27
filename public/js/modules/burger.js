
export function burger() {

        let burger = document.querySelector('.header__burger');
        let nav = document.querySelector('.nav-header');
        let win = document.querySelector('html');
        
        if(burger) {
            burger.addEventListener('click', ()=>{
                burger.classList.toggle('burger');
                nav.classList.toggle('show-menu');
                win.classList.toggle('unScroll');
            })
        }
       
}