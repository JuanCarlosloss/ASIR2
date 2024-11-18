// Animación de los dados
document.addEventListener('DOMContentLoaded', () => {
    const diceElements = document.querySelectorAll('.dice');
    const resultContainer = document.getElementById('result');

    diceElements.forEach((dice, index) => {
        setTimeout(() => {
            dice.classList.add('rolling');
        }, index * 500); // Añadir un pequeño retraso entre dados
    });

    // Mostrar el resultado después de la animación
    setTimeout(() => {
        resultContainer.style.display = 'block';
    }, (diceElements.length * 500) + 2000); // Tiempo total de animación
});
