<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-light: #a78bfa;
            --primary-dark: #7c3aed;
            --bg-card: #ffffff;
            --border: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: #f9fafb;
            color: var(--text-primary);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .btn-primary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    
    <main>
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>
    
    <script>
        // Carousel functionality
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('carouselTrack');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('carouselDots');
            
            if (!track) return;
            
            const items = track.querySelectorAll('.carousel-item');
            const itemCount = items.length;
            let currentIndex = 0;
            
            // Calculer items visibles selon la largeur d'écran
            function getVisibleItems() {
                if (window.innerWidth <= 640) return 1;
                if (window.innerWidth <= 968) return 2;
                return 3;
            }
            
            // Créer les dots
            const maxSlides = Math.ceil(itemCount / getVisibleItems());
            for (let i = 0; i < maxSlides; i++) {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
            
            function updateCarousel() {
                const itemWidth = items[0].offsetWidth;
                const gap = 24; // 1.5rem
                const offset = currentIndex * (itemWidth + gap);
                track.style.transform = `translateX(-${offset}px)`;
                
                // Update dots
                document.querySelectorAll('.dot').forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }
            
            function goToSlide(index) {
                const maxIndex = Math.ceil(itemCount / getVisibleItems()) - 1;
                currentIndex = Math.max(0, Math.min(index, maxIndex));
                updateCarousel();
            }
            
            prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
            nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));
            
            window.addEventListener('resize', () => {
                updateCarousel();
                // Recréer les dots si nécessaire
                const newMaxSlides = Math.ceil(itemCount / getVisibleItems());
                if (dotsContainer.children.length !== newMaxSlides) {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < newMaxSlides; i++) {
                        const dot = document.createElement('div');
                        dot.classList.add('dot');
                        if (i === currentIndex) dot.classList.add('active');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }
                }
            });
        });
    </script>
</body>
</html>
