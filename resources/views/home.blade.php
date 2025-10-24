@extends('layouts.app')

@section('title', 'Accueil - MangaTracker')

@section('content')
<div class="hero">
    <div class="container">
        <h1 class="hero-title">Découvrez vos prochaines lectures</h1>
        <p class="hero-subtitle">Explorez une sélection de mangas et webtoons recommandés</p>
    </div>
</div>

<section class="carousel-section">
    <div class="container">
        <h2 class="section-title">Lectures en vedette</h2>
        
        @if($featuredBooks->count() > 0)
            <div class="carousel-container">
                <button class="carousel-btn carousel-prev" id="prevBtn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                
                <div class="carousel-wrapper">
                    <div class="carousel-track" id="carouselTrack">
                        @foreach($featuredBooks as $book)
                            <div class="carousel-item">
                                <div class="book-card">
                                    <div class="book-image">
                                        <img src="{{ $book->image_url }}" alt="{{ $book->title }}">
                                        <div class="book-overlay">
                                            <a href="{{ $book->web_link }}" target="_blank" class="btn-primary">
                                                Lire maintenant
                                            </a>
                                        </div>
                                    </div>
                                    <div class="book-info">
                                        <span class="book-type">{{ ucfirst($book->type) }}</span>
                                        <h3 class="book-title">{{ $book->title }}</h3>
                                        @if($book->description)
                                            <p class="book-description">{{ Str::limit($book->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <button class="carousel-btn carousel-next" id="nextBtn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
            
            <div class="carousel-dots" id="carouselDots"></div>
        @else
            <div class="empty-state">
                <p>Aucune lecture en vedette pour le moment.</p>
                <a href="{{ route('books.create') }}" class="btn-primary">Ajouter une lecture</a>
            </div>
        @endif
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <h2>Commencez à suivre vos lectures</h2>
            <p>Créez votre collection personnelle de mangas et webtoons</p>
            <a href="{{ route('books.create') }}" class="btn-primary">Ajouter ma première lecture</a>
        </div>
    </div>
</section>

<style>
.hero {
    padding: 4rem 0 2rem;
    text-align: center;
}

.hero-title {
    font-size: 3rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-secondary);
}

.carousel-section {
    padding: 3rem 0;
}

.section-title {
    font-size: 2rem;
    margin-bottom: 2rem;
    color: var(--text-primary);
}

.carousel-container {
    position: relative;
    padding: 0 60px;
}

.carousel-wrapper {
    overflow: hidden;
    border-radius: 12px;
}

.carousel-track {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.5s ease;
}

.carousel-item {
    min-width: calc(33.333% - 1rem);
    flex-shrink: 0;
}

.book-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
}

.book-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 12px 32px rgba(139, 92, 246, 0.3);
}

.book-image {
    position: relative;
    aspect-ratio: 3/4;
    overflow: hidden;
}

.book-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.book-card:hover .book-overlay {
    opacity: 1;
}

.book-info {
    padding: 1.25rem;
}

.book-type {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--primary);
    color: white;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}

.book-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.book-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: var(--bg-card);
    border: 1px solid var(--border);
    color: var(--primary);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    z-index: 10;
}

.carousel-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.carousel-prev {
    left: 0;
}

.carousel-next {
    right: 0;
}

.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--border);
    cursor: pointer;
    transition: all 0.3s;
}

.dot.active {
    background: var(--primary);
    width: 30px;
    border-radius: 5px;
}

.empty-state {
    text-align: center;
    padding: 4rem 0;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.cta-section {
    padding: 3rem 0;
}

.cta-card {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    padding: 3rem;
    border-radius: 16px;
    text-align: center;
}

.cta-card h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.cta-card p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

@media (max-width: 968px) {
    .carousel-item {
        min-width: calc(50% - 0.75rem);
    }
}

@media (max-width: 640px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .carousel-item {
        min-width: 100%;
    }
    
    .carousel-container {
        padding: 0 40px;
    }
}
</style>
@endsection