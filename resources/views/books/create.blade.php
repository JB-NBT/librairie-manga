@extends('layouts.app')

@section('title', 'Ajouter une lecture - MangaTracker')

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title">Ajouter une lecture</h1>
        <p class="page-subtitle">Ajoutez un nouveau manga ou webtoon à votre collection</p>
    </div>
</div>

<section class="form-section">
    <div class="container">
        <div class="form-container">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="book-form">
                @csrf
                
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="title" class="form-label">Titre *</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="form-input @error('title') error @enderror" 
                                value="{{ old('title') }}"
                                required
                                placeholder="Ex: One Piece, Tower of God..."
                            >
                            @error('title')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="type" class="form-label">Type *</label>
                            <select id="type" name="type" class="form-select @error('type') error @enderror" required>
                                <option value="manga" {{ old('type') == 'manga' ? 'selected' : '' }}>Manga</option>
                                <option value="webtoon" {{ old('type') == 'webtoon' ? 'selected' : '' }}>Webtoon</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="web_link" class="form-label">Lien vers la lecture *</label>
                    <input 
                        type="url" 
                        id="web_link" 
                        name="web_link" 
                        class="form-input @error('web_link') error @enderror" 
                        value="{{ old('web_link') }}"
                        required
                        placeholder="https://exemple.com/mon-manga/chapitre-1"
                    >
                    @error('web_link')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <small class="form-hint">Le lien vers votre dernier chapitre lu</small>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description (optionnel)</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-textarea @error('description') error @enderror"
                        rows="4"
                        placeholder="Ajoutez une courte description ou vos impressions..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image" class="form-label">Image de couverture *</label>
                    <div class="file-input-wrapper">
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            class="file-input @error('image') error @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            required
                        >
                        <label for="image" class="file-input-label">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <span>Cliquez pour choisir une image</span>
                        </label>
                    </div>
                    @error('image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <small class="form-hint">Formats acceptés : JPG, PNG, GIF, WEBP (max 2MB)</small>
                </div>
                
                <div id="imagePreview" class="image-preview"></div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="is_featured" 
                            class="form-checkbox"
                            {{ old('is_featured') ? 'checked' : '' }}
                        >
                        <span>Mettre en vedette (apparaîtra dans le carousel de la page d'accueil)</span>
                    </label>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('books.index') }}" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; margin-right: 8px; vertical-align: middle;">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.form-section {
    padding: 3rem 0 4rem;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 2.5rem;
}

.book-form {
    width: 100%;
}

.form-row {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-col-2 {
    grid-column: span 1;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-input.error,
.form-textarea.error,
.form-select.error,
.file-input.error + .file-input-label {
    border-color: var(--error);
}

.form-hint {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.file-input-wrapper {
    position: relative;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-input-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 2rem;
    background: var(--bg-dark);
    border: 2px dashed var(--border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.file-input-label:hover {
    border-color: var(--primary);
    background: var(--bg-hover);
}

.file-input-label svg {
    color: var(--primary);
}

.file-input-label span {
    color: var(--text-secondary);
    font-weight: 500;
}

.image-preview {
    margin-top: 1rem;
    text-align: center;
}

.image-preview img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    border: 1px solid var(--border);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    color: var(--text-primary);
}

.checkbox-label:hover {
    color: var(--primary);
}

.form-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--primary);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

@media (max-width: 640px) {
    .form-container {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .form-actions .btn-primary,
    .form-actions .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
