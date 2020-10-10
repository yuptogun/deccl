@extends('_')

@push('styles')
<style>
html, body {
    width: 100%;
    height: 100%;
}
#form-signin {
    min-width: 240px;
}
#inputEmail {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
#inputPassword {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
@endpush

@section('body')
<div class="d-flex h-100 justify-content-center align-items-center">
    <form class="ajax text-center" id="form-signin" data-method="POST" data-action="{{ route('api.auth.login') }}">
        <h1 class="h3 mb-3 font-weight-normal">로그인</h1>
        <p>계정이 없다면? <a href="#">가입하기</a></p>
        <div class="form-errors"></div>
        <label for="inputEmail" class="sr-only">이메일 주소</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="이메일 주소" autofocus="on" required />
        <label for="inputPassword" class="sr-only">비밀번호</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="비밀번호" required />
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" value="1"> 로그인 유지
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
        <p class="mt-5 mb-3 text-muted">© 2020{{ date('Y') > 2020 ? ' - '.date('Y') : '' }}, {{ env('APP_NAME') }}</p>
    </form>
</div>
@endsection