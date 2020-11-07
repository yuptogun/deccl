<?php
namespace App\Models\User;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * user_properties
 * 
 * 사용자의 맞춤설정 속성들
 */
class Property extends Model
{
    protected $table = 'user_properties';

    protected $fillable = [
        'user_id', 'username', 'profile_picture', 'reputation', 'locale',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}