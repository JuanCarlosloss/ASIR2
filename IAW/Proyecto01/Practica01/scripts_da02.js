
document.addEventListener('DOMContentLoaded', () => {
    const diceElements = document.querySelectorAll('.dice');
    const resultContainer = document.getElementById('result');

    diceElements.forEach((dice, index) => {
        setTimeout(() => {
            dice.classList.add('rolling');
        }, index * 500); 
    });


    setTimeout(() => {
        resultContainer.style.display = 'block';
    }, (diceElements.length * 500) + 2000); 
});
