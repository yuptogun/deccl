<?php
namespace App\Http\Controllers\API\User;

use Aws\S3\S3Client;
use Illuminate\Http\Request;

use App\Models\User;

use App\Http\Controllers\APIController;

/**
 * 사용자 상세정보 관리 관련 컨트롤러
 */
class PropertyController extends APIController
{
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        if (!$user || $user != $request->user) return $this->responseAJAX(401, 'Unauthorized.');

        $updated = $this->_updateUserProperty($user, $request->input());
        return $updated ?
            $this->responseAJAX(200, '성공', '#') :
            $this->responseAJAX(500, '실패! 다시 시도해 주세요.');
    }

    /**
     * 프로필 사진 교체 폼 제출시 실행됨
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $user 사용자번호
     * @return \Illuminate\Http\Response
     */
    public function updateProfilePicture(Request $request, $user)
    {
        $user = User::find($user);
        if (!$user || $user != $request->user) return $this->responseAJAX(401, 'Unauthorized.');

        $this->validate($request, [
            'profile_picture' => 'required|image|max:5120', // 5MB
        ]);

        $file = $request->file('profile_picture');
        $key = 'profile-pictures/'.implode('_', [$user->getKey(), time()]).'.'.$file->getClientOriginalExtension();

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'ap-northeast-2',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        $upload = $s3->putObject([
            'Bucket' => 'deccl',
            'Key' => $key,
            'SourceFile' => $file->getRealPath(),
            'ACL' => 'public-read',
        ]);
        if ($profile_picture = $upload['ObjectURL']) {
            $this->_updateUserProperty($user, compact('profile_picture'));
        }

        return $this->responseAJAX(200, '성공', '#');
    }

    protected function _updateUserProperty(User $user, $fill)
    {
        $property = $user->property()->firstOrNew();
        $property->fill($fill);
        return $property->save();
    }
}