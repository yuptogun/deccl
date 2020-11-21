<fieldset>
    <legend>프로필 변경</legend>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label">프로필 사진</label>
            <div class="col-lg-9">
                <div class="row">
@if ($user->profile_picture)
                    <div class="col-4">
                        <img src="{{ $user->property->profile_picture }}" class="img-thumbnail" /><br />
                        <form class="ajax"
                            data-method="PUT"
                            data-action="{{ route('api.user.property.update', compact('user')) }}"
                            data-confirm="정말 삭제하시겠습니까?">
                            <input type="hidden" name="profile_picture" value="" />
                            <button type="submit" class="btn btn-link text-warning"><small>삭제</small></button>
                        </form>
                    </div>
@endif
                    <div class="col{{ $user->profile_picture ? '-8' : '' }}">
                        <form class="ajax" enctype="multipart/form-data"
                            data-method="POST"
                            data-action="{{ route('api.user.property.updateProfilePicture', compact('user')) }}">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="profile_picture" class="custom-file-input" id="profilePictureInput" aria-describedby="profilePictureButton">
                                    <label class="custom-file-label" for="profilePictureInput">파일 선택</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit" id="profilePictureButton">업로드</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form class="ajax" data-method="PUT" data-action="{{ route('api.user.property.update', compact('user')) }}">
        <div class="form-group row">
            <label for="username" class="col-lg-3 col-form-label">사용자 ID</label>
            <div class="col-lg-9">
                <div class="input-group">
                    <input type="text" name="username" value="{{ $user->property ? $user->property->username : '' }}"
                    class="form-control"
                    placeholder="영대소문자, 숫자, _, - 만 허용"
                    pattern="[a-zA-Z0-9\-_]+" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">저장</button>
                    </div>
                </div>
                <small class="form-text text-muted">이 값을 설정하시면 로그인이나 내 정보 페이지에서 사용 가능합니다.</small>
            </div>
        </div>
    </form>
</fieldset>