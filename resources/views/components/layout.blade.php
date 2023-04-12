<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name') }}</title>

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<body>
<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
        <a href="../" class="navbar-brand">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                @haskey(app(\App\Services\MailerLite\MailerLiteApi::class))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subscribers.create') }}">Add Subscriber</a>
                    </li>
                @endhaskey
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('api-keys.create') }}">API Key</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto">
                <li class="nav-item">
                    <a target="_blank" rel="noopener" class="nav-link" href="#"><i class="bi bi-linkedin"></i> LinkedIn</a>
                </li>
            </ul>
        </div>
    </div>
</div>
    <div class="container">
        {{ $slot }}
    </div>
{{--        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})--}}
</body>
</html>