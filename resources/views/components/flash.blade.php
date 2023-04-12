@if (session()->has('message'))
    <div class="alert alert-{{ session('state') }}" role="alert">
        <p>{{ session('message') }}</p>
    </div>
@endif