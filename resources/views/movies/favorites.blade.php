@extends('layouts.app')

@section('title', __('messages.my_favorites'))

@section('content')
<div class="container">
    <h1 class="mb-4">@lang('messages.my_favorites')</h1>

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
                                @lang('messages.details')
                            </a>
                            <button class="btn btn-sm btn-outline-danger float-end remove-favorite"
                                    data-imdb-id="{{ $favorite->imdb_id }}">
                                @lang('messages.remove')
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            @lang('messages.no_favorites')
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

        if (confirm('@lang('messages.confirm_remove_favorite')')) {
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
                    showToast('@lang('messages.removed_from_favorites')', 'success');
                },
                error: function() {
                    showToast('@lang('messages.remove_favorite_error')', 'error');
                }
            });
        }
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
