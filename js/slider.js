document.addEventListener('DOMContentLoaded', () => {
    const rangeSlider = document.getElementById('rangeSlider');
    const images = document.querySelectorAll('#imageContainer img');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    const dateElements = document.querySelectorAll('#dates span');
    const textElements = document.querySelectorAll('#textContainer p');
    let currentIndex = parseInt(rangeSlider.value, 10);
    let startX;
    let startTime;

    function updateContent() {
        images.forEach((img, index) => {
            if (index + 1 === currentIndex) {
                img.classList.add('active');
                img.classList.remove('prev');
            } else if (index + 1 === currentIndex - 1) {
                img.classList.add('prev');
                img.classList.remove('active');
            } else {
                img.classList.remove('active', 'prev');
            }
        });
        dateElements.forEach((dateEl, index) => {
            dateEl.classList.toggle('active', index + 1 === currentIndex);
        });
        textElements.forEach((textEl, index) => {
            textEl.classList.toggle('active', index + 1 === currentIndex);
        });
    }

    rangeSlider.addEventListener('input', (event) => {
        currentIndex = parseInt(event.target.value, 10);
        updateContent();
    });

    prevButton.addEventListener('click', () => {
        if (currentIndex > 1) {
            currentIndex--;
            rangeSlider.value = currentIndex;
            updateContent();
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < images.length) {
            currentIndex++;
            rangeSlider.value = currentIndex;
            updateContent();
        }
    });

    document.getElementById('imageContainer').addEventListener('touchstart', (event) => {
        startX = event.touches[0].clientX;
        startTime = Date.now();
    });

    document.getElementById('imageContainer').addEventListener('touchmove', (event) => {
        if (startX === undefined) return;
        const moveX = event.touches[0].clientX;
        const deltaX = moveX - startX;
        const elapsedTime = Date.now() - startTime;
        const velocity = Math.abs(deltaX) / elapsedTime;

        if (Math.abs(deltaX) > 30) { // Sensibilité du geste de glissement
            if (deltaX < 0 && currentIndex < images.length) { // Glissement vers la gauche
                if (velocity > 0.3) { // Vélocité pour changement rapide
                    currentIndex++;
                } else {
                    currentIndex = Math.min(currentIndex + 1, images.length);
                }
                rangeSlider.value = currentIndex;
                updateContent();
            } else if (deltaX > 0 && currentIndex > 1) { // Glissement vers la droite
                if (velocity > 0.3) { // Vélocité pour changement rapide
                    currentIndex--;
                } else {
                    currentIndex = Math.max(currentIndex - 1, 1);
                }
                rangeSlider.value = currentIndex;
                updateContent();
            }
            startX = undefined; // Réinitialise startX après traitement du geste
        }
    });

    document.getElementById('imageContainer').addEventListener('touchend', () => {
        startX = undefined; // Réinitialise startX lorsque le geste est terminé
    });

    // Ajout de la gestion des clics sur les dates
    dateElements.forEach(dateEl => {
        dateEl.addEventListener('click', () => {
            currentIndex = parseInt(dateEl.getAttribute('data-index'), 10);
            rangeSlider.value = currentIndex;
            updateContent();
        });
    });

    updateContent(); // Initialisation
});