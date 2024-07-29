// Charge les modules une fois le DOM chargé
import { screenSize } from "./modules/productions.js";
window.addEventListener('DOMContentLoaded', async () => {

    document.querySelector('body').classList.add('delayBody'); 
    
    const cr_burger = await import("./modules/burger.js");
    const verif = await import("./modules/verif.js");
    // const screen = await import("./modules/productions.js");

    cr_burger.burger(); verif.verif(); screenSize();
})