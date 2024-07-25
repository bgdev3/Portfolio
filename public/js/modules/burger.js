

export function burger() {

        let burger = document.querySelector('.header_burger');
        console.log(burger);
        burger.addEventListener('click', ()=>{
            burger.classList.toggle('burger');
        })
 
}