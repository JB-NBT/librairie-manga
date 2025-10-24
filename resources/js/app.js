// Carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('carouselDots');
    
    if (!track) return; // Pas de carousel sur cette page
    
    const items = track.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    
    if (totalItems === 0) return;
    
    let currentIndex = 0;
    let itemsPerView = getItemsPerView();
    let maxIndex = Math.max(0, totalItems - itemsPerView);
    
    // Créer les dots de navigation
    function createDots() {
        dotsContainer.innerHTML = '';
        const dotsCount = Math.ceil(totalItems / itemsPerView);
        
        for (let i = 0; i < dotsCount; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i * itemsPerView));
            dotsContainer.appendChild(dot);
        }
    }
    
    // Déterminer le nombre d'items visibles selon la taille d'écran
    function getItemsPerView() {
        if (window.innerWidth < 640) return 1;
        if (window.innerWidth < 968) return 2;
        return 3;
    }
    
    // Mettre à jour la position du carousel
    function updateCarousel() {
        const itemWidth = items[0].offsetWidth;
        const gap = 24; // 1.5rem = 24px
        const offset = -(currentIndex * (itemWidth + gap));
        track.style.transform = `translateX(${offset}px)`;
        updateDots();
    }
    
    // Mettre à jour les dots actifs
    function updateDots() {
        const dots = dotsContainer.querySelectorAll('.dot');
        const activeDotIndex = Math.floor(currentIndex / itemsPerView);
        
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeDotIndex);
        });
    }
    
    // Aller à une slide spécifique
    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateCarousel();
    }
    
    // Navigation précédente
    function goPrev() {
        currentIndex = Math.max(0, currentIndex - 1);
        updateCarousel();
    }
    
    // Navigation suivante
    function goNext() {
        currentIndex = Math.min(maxIndex, currentIndex + 1);
        updateCarousel();
    }
    
    // Event listeners
    prevBtn.addEventListener('click', goPrev);
    nextBtn.addEventListener('click', goNext);
    
    // Navigation au clavier
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') goPrev();
        if (e.key === 'ArrowRight') goNext();
    });
    
    // Gestion du redimensionnement
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            itemsPerView = getItemsPerView();
            maxIndex = Math.max(0, totalItems - itemsPerView);
            currentIndex = Math.min(currentIndex, maxIndex);
            createDots();
            updateCarousel();
        }, 250);
    });
    
    // Auto-play optionnel (décommenter pour activer)
    /*
    let autoplayInterval = setInterval(() => {
        if (currentIndex >= maxIndex) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        updateCarousel();
    }, 5000);
    
    // Pause au survol
    track.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    track.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(() => {
            if (currentIndex >= maxIndex) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            updateCarousel();
        }, 5000);
    });
    */
    
    // Initialisation
    createDots();
    updateCarousel();
});

// Animation fade-in pour les alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Preview d'image avant upload
function setupImagePreview() {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    
    if (!imageInput || !preview) return;
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
                preview.innerHTML = `<img src="${event.target.result}" alt="Preview" style="max-width: 300px; border-radius: 8px;">`;
            };
            
            reader.readAsDataURL(file);
        }
    });
}

document.addEventListener('DOMContentLoaded', setupImagePreview);