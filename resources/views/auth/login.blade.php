@extends('layouts.empty')

@section('title', 'Login')

@section('content')
<div class="card shadow" style="width: 350px;">
    <div class="card-body">
        <h4 class="card-title text-center mb-4">{{ __('Login') }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">{{ __('Username') }}</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
        </form>
    </div>
</div>
@endsection
