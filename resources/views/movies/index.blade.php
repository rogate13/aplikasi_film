@extends('layouts.app')

@section('title', 'Movies')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <form id="searchForm" class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="s" placeholder="Search..." value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="y" placeholder="Year" value="{{ $year ?? '' }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="type">
                    <option value="">All Types</option>
                    <option value="movie" {{ ($type ?? '') === 'movie' ? 'selected' : '' }}>Movie</option>
                    <option value="series" {{ ($type ?? '') === 'series' ? 'selected' : '' }}>Series</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row" id="moviesContainer">
    @forelse($movies['Search'] ?? [] as $movie)
        <div class="col-md-4 mb-4">
            <div class="card movie-card h-100">
                <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}"
                     class="card-img-top lazy"
                     alt="{{ $movie['Title'] }}"
                     data-src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie['Title'] }}</h5>
                    <p class="card-text">
                        <small class="text-muted">{{ $movie['Year'] }} | {{ $movie['Type'] }}</small>
                    </p>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('movies.show', $movie['imdbID']) }}" class="btn btn-sm btn-outline-primary">
                        Details
                    </a>
                    @auth
                        <i class="{{ in_array($movie['imdbID'], $favoriteIds ?? []) ? 'fas' : 'far' }} fa-star favorite-btn float-end fs-4"
                           data-imdb-id="{{ $movie['imdbID'] }}"
                           data-title="{{ $movie['Title'] }}"
                           data-year="{{ $movie['Year'] }}"
                           data-poster="{{ $movie['Poster'] }}"
                           title="{{ in_array($movie['imdbID'], $favoriteIds ?? []) ? 'Remove from favorites' : 'Add to favorites' }}"></i>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h4>No movies found</h4>
            <p>Try a different search</p>
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Favorite Functionality
    $(document).on('click', '.favorite-btn', function() {
        const btn = $(this);
        const imdbID = btn.data('imdb-id');
        const isFavorite = btn.hasClass('fas');

        $.ajax({
            url: isFavorite ? `/favorites/${imdbID}` : '/favorites',
            type: isFavorite ? 'DELETE' : 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                imdb_id: imdbID,
                title: btn.data('title'),
                year: btn.data('year'),
                poster: btn.data('poster')
            },
            success: function() {
                btn.toggleClass('fas far');
                const newTitle = btn.hasClass('fas')
                    ? 'Remove from favorites'
                    : 'Add to favorites';
                btn.attr('title', newTitle);

                // Show toast notification
                const message = btn.hasClass('fas')
                    ? 'Added to favorites'
                    : 'Removed from favorites';
                showToast(message);
            },
            error: function() {
                showToast('Error updating favorites', 'error');
            }
        });
    });

    function showToast(message, type = 'success') {
        const toast = $(`
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast align-items-center text-white bg-${type} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `);

        $('body').append(toast);
        setTimeout(() => toast.remove(), 3000);
    }
});
</script>
@endsection
