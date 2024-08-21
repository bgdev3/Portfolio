

export function showContentProduction(){

    let btnAdd = document.querySelectorAll('button.btn-realisation');
    let btnClose = document.querySelectorAll('button.btn-close');
    let content =  document.querySelectorAll('div.content-container');

    // Boucle sur chaque bouton voirplus, si l'index du tableau correspond à l'index du tableau content,
    // Alors applique les classes coorepondante.
    btnAdd.forEach((el, index) => {
        el.addEventListener('click', ()=>{
            content.forEach((ct, iContent) => {
                if(index == iContent) {
                    ct.classList.remove('hide-content');
                    ct.classList.add('show-content');
                }
            })
         })
    })

    btnClose.forEach((btn, iBtn) => {
        btn.addEventListener('click', ()=>{
            content.forEach((ct, iContent) => {
                if(iBtn == iContent) {
                    ct.classList.add('hide-content');
                    ct.classList.remove('show-content');
                }
            })
        })
    })

}