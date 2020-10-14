@extends('_full')

@section('body')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3">안녕하세요, {{ $user->name }}님!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form class="ajax" data-action="{{ route('user.update', compact('user')) }}">
                <fieldset>
                    <legend>정보 변경</legend>
                    <div class="form-group row">
                        <label for="email" class="col-lg-3 col-form-label">이메일</label>
                        <div class="col-lg-9">
@if ($user->has_verified_email)
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control disabled" disabled />
                            <small class="form-text text-muted">인증된 이메일은 변경할 수 없습니다. ({{ $user->email_verified_at->format('Y. n. j.') }} 인증완료)</small>
@else
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" />
                            <small class="form-text text-muted">변경하신 이메일로 인증 메일을 발송합니다. 반드시 인증 후 사용해 주세요.</small>
@endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-3 col-form-label">이름 (닉네임)</label>
                        <div class="col-lg-9">
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                            <small class="form-text text-muted">공란으로 두시면 이메일을 이름으로 사용합니다.</small>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-lg-6"></div>
    </div>
</div>
@endsection