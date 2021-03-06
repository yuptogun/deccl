<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ app('url')->route('home.index') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('comment.create') }}">새 댓글 쓰기</a>
                </li>
            </ul>
            <ul class="navbar-nav nav-right">
@if (request()->user)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ request()->user->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('user.show', ['user' => request()->user]) }}">내 정보</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('form-logout').submit();">로그아웃</a>
                        <form id="form-logout"
                            method="POST"
                            action="{{ app('url')->route('auth.logout') }}"></form>
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