

export function screenSize() {
    let screenWidth = screen.width;
    // let img = document.getElementById('img');
       
    console.log(screenWidth);
    // if(img)
    fetch(`index.php?controller=productions&action=addSlide&screen=${screenWidth}`)

}