
export function animateTitle() {

  const aText =  ["Salut", "!"];
  const iSpeed = 100; // Delai de l'affichage
  let iIndex = 0; // Début de l'affichage
  let iArrLength = aText[0].length; // longeur du tableau
  let iScrollAt = 20; 
   
  let iTextPos = 0; // Initilise la position du texte
  let sContents = ''; 
  let iRow; // initailise la row courante
  let destination = document.querySelector('.text-style span');
  let presentation = document.querySelector('.presentation');

  /**
   * Permet l'affichage en print du mot de bienvenue
   */
  function typewriter() {
      sContents =  ' ';
      iRow = Math.max(0, iIndex-iScrollAt);
    // Tant que l'index du tableau est inferieur à iIndex
      while ( iRow < iIndex ) {
        // Ajoute les lettres et un espacement
        sContents += aText[iRow++] + ' ';
      }
      // Ajoute le contenu et l'underscore
      destination.innerHTML = sContents + aText[iIndex].substring(0, iTextPos) + '_';

      // Si l'index de la position du mot et inférieur à la taille de l'index du tableau
      if ( iTextPos++ == iArrLength ) {
        iTextPos = 0;
        iIndex++;
        // Si l'index d'affichage n'est pas égal à la longeur du tableau
        if ( iIndex != aText.length ) {
        iArrLength = aText[iIndex].length;
        setTimeout(typewriter, 400);
        }
      } else {
        setTimeout(typewriter, iSpeed);
      }

      // Si l'index est égal à la longeur du tableau
      if(iIndex == aText.length ) {
        // Lance l'animation de l'underscore
        lastLetterAnimte(destination);
      }
    }
    // Si on se trouve sur la page
    if(presentation)
    setTimeout(typewriter, 1000);
}
      
/**
 * 
 * @param {objectHTML} destination Elément html
 * @returns {function} fonction permettant la gérence de classe avec settimeout afin de créer un effet de clignotement
 */
function lastLetterAnimte(destination) {

  // Récupère le contenu html
  const content = destination.innerHTML;
  // Crée un element span afin d'appliqer une classe css
  const bdi = document.createElement('bdi');
  // récupère l'underscore'
  let  letter = destination.innerHTML.charAt(content.length - 1);
  // Stocke le mot sans l'underscore
  let newContent = content.slice(0, -1);
  let occ = 0;

  bdi.innerHTML = letter;
  bdi.style.display="inline";
  destination.innerHTML = newContent;
  destination.appendChild(bdi);
  
  /**
   * Jusqu'à 5 clignotement, ajout de classe css avec setTimeout
   */
  function lastLetter() {
  
    if(occ <= 4) {
      setTimeout(() => { bdi.classList.toggle('hideLetter'); }, 500);
      setTimeout(lastLetter, 500);

    } else {
      setTimeout(() => {bdi.classList.add('hideLetter'); }, 500);
    }
    occ ++;
  }

  return lastLetter();
}