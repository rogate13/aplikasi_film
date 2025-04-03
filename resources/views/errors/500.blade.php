@extends('layouts.empty')

@section('title', 'Server Error')

@section('content')
<div class="text-center">
    <div class="error-container" data-aos="zoom-in">
        <h1 class="display-1 text-danger">505</h1>
        <h2 class="mb-4">Server Error</h2>
        <div class="error-details mb-4">
            <p>Oops! Something went wrong on our servers.</p>
            <p>We're working to fix the issue. Please try again later.</p>
        </div>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-home me-1"></i> Take Me Home
            </a>
            <a href="mailto:support@cinemagic.com" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-envelope me-1"></i> Contact Support
            </a>
        </div>
    </div>

    <div class="mt-5" data-aos="fade-up" data-aos-delay="300">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">While you're here...</h5>
                <p class="card-text">Check out these popular movies you might like:</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-sm btn-outline-primary">Action</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Comedy</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Drama</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Sci-Fi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .display-1 {
        font-size: 6rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {
        .display-1 {
            font-size: 4rem;
        }

        .error-actions .btn {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
@endsection
