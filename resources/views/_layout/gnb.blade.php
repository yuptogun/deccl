<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">준비중</a>
                </li>
            </ul>
            <ul class="navbar-nav nav-right">
@if ($user)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ $user->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">내 정보</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">로그아웃</a>
                    </div>
                </li>
@else
                <li class="nav-item">
                    <a href="{{ app('url')->route('auth.login') }}" class="nav-link">로그인</a>
                </li>
@endif
            </ul>
        </div>
    </div>
</nav>