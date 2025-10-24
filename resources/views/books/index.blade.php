@extends('layouts.app')

@section('title', 'Mes Lectures - MangaTracker')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="header-content">
            <div>
                <h1 class="page-title">Mes Lectures</h1>
                <p class="page-subtitle">Gérez votre collection de mangas et webtoons</p>
            </div>
            <a href="{{ route('books.create') }}" class="btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; margin-right: 8px; vertical-align: middle;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Ajouter une lecture
            </a>
        </div>
    </div>
</div>

<section class="books-section">
    <div class="container">
        @if($books->count() > 0)
            <div class="books-grid">
                @foreach($books as $book)
                    <div class="book-item">
                        <div class="book-item-image">
                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}">
                            @if($book->is_featured)
                                <span class="featured-badge">⭐ Vedette</span>
                            @endif
                        </div>
                        
                        <div class="book-item-content">
                            <div class="book-item-header">
                                <span class="book-item-type">{{ ucfirst($book->type) }}</span>
                                <span class="book-item-date">{{ $book->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h3 class="book-item-title">{{ $book->title }}</h3>
                            
                            @if($book->description)
                                <p class="book-item-description">{{ Str::limit($book->description, 120) }}</p>
                            @endif
                            
                            <div class="book-item-actions">
                                <a href="{{ $book->web_link }}" target="_blank" class="btn-secondary btn-small">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                    Lire
                                </a>
                                
                                <a href="{{ route('books.edit', $book) }}" class="btn-secondary btn-small">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Éditer
                                </a>
                                
                                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette lecture ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger btn-small">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📚</div>
                <h2>Aucune lecture pour le moment</h2>
                <p>Commencez à construire votre collection de mangas et webtoons</p>
                <a href="{{ route('books.create') }}" class="btn-primary">Ajouter ma première lecture</a>
            </div>
        @endif
    </div>
</section>

<style>
.page-header {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border);
    padding: 2rem 0;
    margin-bottom: 3rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.page-title {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.page-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
}

.books-section {
    padding: 0 0 4rem;
}

.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

.book-item {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
}

.book-item:hover {
    transform: translateY(-4px);
    border-color: var(--primary);
    box-shadow: 0 12px 32px rgba(139, 92, 246, 0.2);
}

.book-item-image {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: var(--bg-dark);
}

.book-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: var(--primary);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.book-item-content {
    padding: 1.5rem;
}

.book-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.book-item-type {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: rgba(139, 92, 246, 0.2);
    color: var(--primary);
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.book-item-date {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.book-item-title {
    font-size: 1.4rem;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
}

.book-item-description {
    color: var(--text-secondary);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.book-item-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-small {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-small svg {
    width: 16px;
    height: 16px;
}

.empty-state {
    text-align: center;
    padding: 6rem 2rem;
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.empty-state p {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .books-grid {
        grid-template-columns: 1fr;
    }
    
    .book-item-actions {
        flex-direction: column;
    }
    
    .btn-small {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection