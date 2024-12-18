// Charge les modules une fois le DOM chargé
window.addEventListener('load', async () => {

    document.querySelector('body').classList.add('delayBody'); 
    
    const cr_burger = await import("./modules/burger.js");
    const verif = await import("./modules/verif.js");
    const realisationAdmin = await import("./modules/realisationAdmin.js");
    const contentProduction = await import("./modules/contentProduction.js");
    const animationTitle = await import("./modules/titleAnimate.js");
    const recaptcha = await import("./modules/recaptcha.js");

    cr_burger.burger(); verif.verif();  realisationAdmin.responsiveArray(); contentProduction.showContentProduction();
    animationTitle.animateTitle(); recaptcha.loadRecaptcha(); 
})
