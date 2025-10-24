<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MangaTracker')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                📚 MangaTracker
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>
                <li><a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">Mes Lectures</a></li>
                <li><a href="{{ route('books.create') }}" class="btn-primary">+ Ajouter</a></li>
            </ul>
        </div>
    </nav>

    <!-- Messages flash -->
    @if(session('success'))
        <div class="alert alert-success">
            <div class="container">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="container">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} MangaTracker - Suivez vos lectures</p>
        </div>
    </footer>
</body>
</html>