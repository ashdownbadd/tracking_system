// profile.js

document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('card-toggle');
    const socialCard = document.getElementById('card-social');

    // Track the state of the card (open/closed)
    let isOpen = false;

    toggleButton.addEventListener('click', () => {
        if (!isOpen) {
            // Trigger the show animation (up)
            socialCard.classList.add('animation');
            socialCard.classList.remove('down-animation'); // Remove any down-animation if it exists
            isOpen = true; // Set the state to open
        } else {
            // Trigger the hide animation (down)
            socialCard.classList.remove('animation'); // Remove the up animation class
            socialCard.classList.add('down-animation'); // Add the down animation
            isOpen = false; // Set the state to closed
        }
    });

    // After the animation ends, reset classes to prevent any issues
    socialCard.addEventListener('animationend', (event) => {
        if (event.animationName === 'down-animation') {
            socialCard.classList.remove('down-animation'); // Clean up after down-animation
        } else if (event.animationName === 'up-animation') {
            // Optional cleanup for the up-animation if needed
        }
    });
});

