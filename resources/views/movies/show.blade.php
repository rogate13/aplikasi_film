@extends('layouts.app')

@section('title', $movie['Title'] ?? __('messages.movie_details'))

@section('hero-section')
<section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ ($movie['Poster'] ?? '') !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/1920x1080?text=No+Backdrop' }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4" data-aos="fade-right">
                <img src="{{ ($movie['Poster'] ?? '') !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}"
                     class="img-fluid rounded shadow movie-detail-poster"
                     alt="{{ $movie['Title'] ?? '' }}">
            </div>
            <div class="col-md-8 text-white" data-aos="fade-left" data-aos-delay="200">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="hero-title mb-2">{{ $movie['Title'] ?? '' }}</h1>
                        <p class="lead mb-4">{{ $movie['Year'] ?? '' }} • {{ $movie['Rated'] ?? 'N/A' }} • {{ $movie['Runtime'] ?? 'N/A' }}</p>
                    </div>
                    <i class="{{ $isFavorite ? 'fas' : 'far' }} fa-star favorite-btn fs-1"
                       data-imdb-id="{{ $movie['imdbID'] ?? '' }}"
                       data-title="{{ $movie['Title'] ?? '' }}"
                       data-year="{{ $movie['Year'] ?? '' }}"
                       data-poster="{{ $movie['Poster'] ?? '' }}"
                       style="cursor: pointer;"
                       title="{{ $isFavorite ? __('messages.remove_favorite') : __('messages.add_favorite') }}"></i>
                </div>

                <div class="movie-meta mb-4">
                    @if(!empty($movie['Genre']))
                        @foreach(explode(',', $movie['Genre']) as $genre)
                            <span class="meta-badge">{{ trim($genre) }}</span>
                        @endforeach
                    @endif
                </div>

                <div class="d-flex align-items-center mb-4">
                    @if(!empty($movie['imdbRating']))
                        <div class="me-4">
                            <div class="d-flex align-items-center">
                                <i class="fab fa-imdb fa-3x me-2 text-warning"></i>
                                <div>
                                    <div class="fs-4 fw-bold">{{ $movie['imdbRating'] }}/10</div>
                                    <small class="text-muted">@lang('messages.imdb_rating')</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($movie['Metascore']))
                        <div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-film fa-3x me-2 text-info"></i>
                                <div>
                                    <div class="fs-4 fw-bold">{{ $movie['Metascore'] }}/100</div>
                                    <small class="text-muted">@lang('messages.metascore')</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <a href="{{ route('movies.index') }}" class="btn btn-outline-light me-2">
                    <i class="fas fa-arrow-left me-1"></i> @lang('messages.back_to_movies')
                </a>
                @if(!empty($movie['Website']) && $movie['Website'] !== 'N/A')
                    <a href="{{ $movie['Website'] }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt me-1"></i> @lang('messages.official_website')
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8" data-aos="fade-up">
        <div class="detail-section mb-4">
            <h3 class="mb-4">@lang('messages.plot')</h3>
            <p class="lead">{{ $movie['Plot'] ?? __('messages.no_plot_available') }}</p>

            @if(!empty($movie['Director']) && $movie['Director'] !== 'N/A')
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>@lang('messages.director')</h5>
                        <p>{{ $movie['Director'] }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>@lang('messages.writers')</h5>
                        <p>{{ $movie['Writer'] ?? 'N/A' }}</p>
                    </div>
                </div>
            @endif

            @if(!empty($movie['Actors']) && $movie['Actors'] !== 'N/A')
                <div class="mt-4">
                    <h5>@lang('messages.cast')</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(explode(',', $movie['Actors']) as $actor)
                            <span class="badge bg-secondary">{{ trim($actor) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if(!empty($movie['Ratings']))
        <div class="detail-section mb-4">
            <h3 class="mb-4">@lang('messages.ratings')</h3>
            <div class="row">
                @foreach($movie['Ratings'] as $rating)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $rating['Source'] }}</h5>
                                <div class="display-4 fw-bold text-primary">{{ $rating['Value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="detail-section mb-4">
            <h3 class="mb-4">@lang('messages.details')</h3>
            <ul class="list-group list-group-flush">
                @if(!empty($movie['Released']) && $movie['Released'] !== 'N/A')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('messages.release_date')</span>
                        <span class="fw-bold">{{ $movie['Released'] }}</span>
                    </li>
                @endif

                @if(!empty($movie['Language']) && $movie['Language'] !== 'N/A')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('messages.language')</span>
                        <span class="fw-bold">{{ $movie['Language'] }}</span>
                    </li>
                @endif

                @if(!empty($movie['Country']) && $movie['Country'] !== 'N/A')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('messages.country')</span>
                        <span class="fw-bold">{{ $movie['Country'] }}</span>
                    </li>
                @endif

                @if(!empty($movie['BoxOffice']) && $movie['BoxOffice'] !== 'N/A')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('messages.box_office')</span>
                        <span class="fw-bold">{{ $movie['BoxOffice'] }}</span>
                    </li>
                @endif

                @if(!empty($movie['Production']) && $movie['Production'] !== 'N/A')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('messages.production')</span>
                        <span class="fw-bold">{{ $movie['Production'] }}</span>
                    </li>
                @endif
            </ul>
        </div>

        @if(!empty($movie['Awards']) && $movie['Awards'] !== 'N/A' && $movie['Awards'] !== 'None')
        <div class="detail-section">
            <h3 class="mb-4">@lang('messages.awards')</h3>
            <div class="alert alert-warning">
                <i class="fas fa-trophy me-2"></i> {{ $movie['Awards'] }}
            </div>
        </div>
        @endif
    </div>
</div>

@if(!empty($movie['Type']) && $movie['Type'] === 'series' && !empty($movie['totalSeasons']))
<div class="row mt-4">
    <div class="col-12">
        <div class="detail-section">
            <h3 class="mb-4">@lang('messages.seasons')</h3>
            <div class="d-flex flex-wrap gap-2">
                @for($i = 1; $i <= $movie['totalSeasons']; $i++)
                    <a href="#" class="btn btn-outline-primary">@lang('messages.season') {{ $i }}</a>
                @endfor
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Favorite Functionality
    $('.favorite-btn').click(function() {
        const btn = $(this);
        const imdbID = btn.data('imdb-id');

        // Add pulse animation
        btn.addClass('animate__animated animate__pulse');

        setTimeout(() => {
            btn.removeClass('animate__animated animate__pulse');

            if (btn.hasClass('fas')) {
                // Remove favorite
                $.ajax({
                    url: `/favorites/${imdbID}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        imdb_id: imdbID
                    },
                    success: function(response) {
                        btn.toggleClass('fas far');
                        btn.attr('title', '@lang('messages.add_favorite')');
                        showToast('@lang('messages.removed_from_favorites')', 'success');
                    },
                    error: function() {
                        showToast('@lang('messages.remove_favorite_error')', 'error');
                    }
                });
            } else {
                // Add favorite
                $.ajax({
                    url: '/favorites',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        imdb_id: imdbID,
                        title: btn.data('title'),
                        year: btn.data('year'),
                        poster: btn.data('poster')
                    },
                    success: function(response) {
                        btn.toggleClass('fas far');
                        btn.attr('title', '@lang('messages.remove_favorite')');
                        showToast('@lang('messages.added_to_favorites')', 'success');
                    },
                    error: function() {
                        showToast('@lang('messages.add_favorite_error')', 'error');
                    }
                });
            }
        }, 300);
    });

    // Toast notification function
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

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endsection
