<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Movie App</title>

    <!-- Bootstrap 5 CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome dari CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d253f;
            --secondary-color: #01b4e4;
            --tertiary-color: #90cea1;
            --dark-color: #032541;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(to right, var(--dark-color), var(--primary-color));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            background: linear-gradient(to right, var(--tertiary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            margin: 0 10px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--secondary-color);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .movie-card {
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background: white;
            position: relative;
        }

        .movie-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, var(--secondary-color), var(--tertiary-color));
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 400px;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .movie-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-color);
        }

        .favorite-btn {
            cursor: pointer;
            transition: all 0.3s;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
        }

        .favorite-btn.active, .favorite-btn.fas {
            color: gold;
            text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #0199c4;
            border-color: #0199c4;
        }

        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lazy.loaded {
            opacity: 1;
        }

        .hero-section {
            background: linear-gradient(rgba(13, 37, 63, 0.8), rgba(13, 37, 63, 0.8)), url('https://image.tmdb.org/t/p/original/wwemzKWzjKYJFfCeiB57q3r4Bcm.png');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
            position: relative;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .movie-detail-poster {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
        }

        .movie-detail-poster:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .movie-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .meta-badge {
            background: linear-gradient(to right, var(--secondary-color), var(--tertiary-color));
            color: white;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .detail-section {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        footer {
            background: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }

        .loading-spinner {
            display: none;
            width: 3rem;
            height: 3rem;
            border: 0.25em solid var(--secondary-color);
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner 0.75s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .card-img-top {
                height: 300px;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('movies.index') }}">CineMagic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">{{ __('Movies') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites.index') }}">{{ __('Favorites') }}</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">{{ __('Logout') }}</button>
                </form>
            </div>
        </div>
    </nav>

    @yield('hero-section')

    <main class="flex-shrink-0">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>

    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} CineMagic - Your Ultimate Movie Experience</p>
            <div class="mt-2">
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- jQuery + Bootstrap JS dari CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- LazySizes for better lazy loading -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>

    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Enhanced Lazy Loading with LazySizes
        document.addEventListener('DOMContentLoaded', function() {
            // Fallback for browsers that don't support IntersectionObserver
            if (!('IntersectionObserver' in window)) {
                const lazyImages = document.querySelectorAll('img.lazy');
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                });
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <script>
    // Inisialisasi lazy load
        document.addEventListener("DOMContentLoaded", function() {
            var lazyLoadInstance = new LazyLoad({
                elements_selector: ".lazy",
                threshold: 100,
                callback_loaded: function(el) {
                    el.classList.add('loaded');
                }
            });

            // Untuk gambar yang dimuat setelah AJAX
            $(document).ajaxComplete(function() {
                lazyLoadInstance.update();
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
