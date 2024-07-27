// Charge les modules une fois le DOM chargé

window.addEventListener('DOMContentLoaded', async () => {

    document.querySelector('body').classList.add('delayBody'); 
    const cr_burger = await import("./modules/burger.js");
    const verif = await import("./modules/verif.js");
    cr_burger.burger(); verif.verif();
})