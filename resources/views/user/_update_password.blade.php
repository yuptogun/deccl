<form class="ajax" data-method="PUT" data-action="{{ route('api.user.update', compact('user')) }}">
    <input type="hidden" name="type" value="password" />
    <fieldset>
        <legend>비밀번호 변경</legend>
        <div class="form-errors"></div>
        <div class="form-group row">
            <label for="old_password" class="col-lg-4 col-form-label">기존 비밀번호</label>
            <div class="col-lg-8">
                <input type="password" name="old_password" class="form-control" placeholder="보안을 위해 필수 입력" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-lg-4 col-form-label">새 비밀번호</label>
            <div class="col-lg-8">
                <input type="password" name="password" class="form-control" placeholder="6자 이상" minlength="6" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="password_confirm" class="col-lg-4 col-form-label">새 비밀번호 확인</label>
            <div class="col-lg-8">
                <input type="password" name="password_confirm" class="form-control" placeholder="한 번 더 입력" minlength="6" required />
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">변경</button>
        </div>
    </fieldset>
</form>