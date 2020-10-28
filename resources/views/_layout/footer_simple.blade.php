<footer class="container">
    <div class="row">
        <div class="col">
            <p class="text-muted text-center">
                © 2020{{ date('Y') > 2020 ? ' - '.date('Y') : '' }}, <a href="{{ route('home.index') }}" class="text-muted">{{ env('APP_NAME') }}</a>
            </p>
        </div>
    </div>
</footer>