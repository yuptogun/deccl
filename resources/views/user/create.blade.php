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
</style>
@endpush

@section('body')
<div class="d-flex h-100 justify-content-center align-items-center">
    <form class="ajax text-center" id="form-signup" data-method="POST" data-action="{{ route('user.store') }}">
        <h1 class="h3 mb-3 font-weight-normal">회원가입</h1>
        <p>계정이 있다면? <a href="{{ route('auth.login') }}">로그인</a></p>
        <div class="form-errors"></div>
        <label for="inputName" class="sr-only">닉네임</label>
        <input type="text" name="name" id="inputName" class="form-control input-group-stacked" placeholder="닉네임" autofocus="on" />
        <label for="inputEmail" class="sr-only">이메일 주소</label>
        <input type="email" name="email" id="inputEmail" class="form-control input-group-stacked" placeholder="이메일 주소" autofocus="on" required />
        <label for="inputPassword" class="sr-only">비밀번호</label>
        <input type="password" name="password" id="inputPassword" class="form-control input-group-stacked" placeholder="비밀번호" minlength="6" required />
        <label for="inputPasswordConfirm" class="sr-only">비밀번호 확인</label>
        <input type="password" name="password_confirm" id="inputPasswordConfirm" class="form-control input-group-stacked" placeholder="비밀번호 확인" minlength="6" required />
        <div class="checkbox mb-3 mt-3">
            <label>
                <input type="checkbox" name="agreed_terms" value="1" required />
                <a href="#" data-toggle="modal" data-target="#modalTerms">{{ env('APP_NAME') }} 이용약관</a>에 동의합니다.
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">가입</button>
        <p class="mt-5 mb-3 text-muted">© 2020{{ date('Y') > 2020 ? ' - '.date('Y') : '' }}, {{ env('APP_NAME') }}</p>
    </form>
</div>
<div class="modal fade" id="modalTerms" tabindex="-1" aria-labelledby="modalLabelTerms" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelTerms">{{ env('APP_NAME') }} 이용약관</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>개인정보는 제3자에게 제공되지 않습니다.</li>
                    <li>모든 기사의 저작권은 링크로 연결된 원저작자에게 있습니다.</li>
                    <li>모든 댓글콘텐츠의 저작권은 작성자 회원에게 귀속됩니다.</li>
                    <li>미풍양속을 저해하는 행위를 자제하여 주시기 바랍니다.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
@endsection