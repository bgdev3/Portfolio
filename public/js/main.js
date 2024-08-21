// Charge les modules une fois le DOM chargé
window.addEventListener('load', async () => {

    document.querySelector('body').classList.add('delayBody'); 
    
    const cr_burger = await import("./modules/burger.js");
    const verif = await import("./modules/verif.js");
    const realisationAdmin = await import("./modules/realisationAdmin.js");
    let contentProduction = await import("./modules/contentProduction.js");
    // const recaptcha = await import("./modules/recpatcha.js");

    cr_burger.burger(); verif.verif();  realisationAdmin.responsiveArray(); contentProduction.showContentProduction();
      
})