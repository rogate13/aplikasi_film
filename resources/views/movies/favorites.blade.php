@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="container">
    <h1 class="mb-4">My Favorite Movies</h1>

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
                <div class="col-md-4 mb-4">
                    <div class="card movie-card h-100">
                        <img src="{{ $favorite->poster !== 'N/A' ? $favorite->poster : 'https://placehold.jp/300x450.png?text=No+Image' }}"
                             class="card-img-top lazy"
                             alt="{{ $favorite->title }}"
                             data-src="{{ $favorite->poster !== 'N/A' ? $favorite->poster : 'https://placehold.jp/300x450.png?text=No+Image' }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->title }}</h5>
                            <p class="card-text">
                                <small class="text-muted">{{ $favorite->year }}</small>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('movies.show', $favorite->imdb_id) }}" class="btn btn-sm btn-outline-primary">
                                Details
                            </a>
                            <button class="btn btn-sm btn-outline-danger float-end remove-favorite"
                                    data-imdb-id="{{ $favorite->imdb_id }}">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            You don't have any favorite movies yet.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Remove favorite
    $('.remove-favorite').click(function() {
        const btn = $(this);
        const imdbID = btn.data('imdb-id');

        $.ajax({
            url: `/favorites/${imdbID}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                btn.closest('.col-md-4').fadeOut(300, function() {
                    $(this).remove();
                    if ($('#moviesContainer').children().length === 0) {
                        location.reload();
                    }
                });
            }
        });
    });

    // Lazy load images
    const lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.classList.add("loaded");
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
});
</script>
@endsection
