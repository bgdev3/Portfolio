
export function screenSize() {
    let screenWith = screen.width;

        let options= {
            method:'POST',
            header: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json'},
            body: JSON.stringify(screenWith)
        }
    console.log(screenWith);
    fetch('index.php?controller=productions&action=index', options);


}