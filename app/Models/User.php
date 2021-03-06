<?php
namespace App\Models;

use App\Models\User\Property;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

/**
 * users
 * 
 * 로그인 사용자 모델
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * 모델 기본동작
     *
     * @todo static::created() 만들어서 인증이메일 날리기
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = Hash::make($user->password);
        });
    }
    protected $fillable = [
        'name', 'email', 'password'
    ];
    protected $hidden = [
        'password',
    ];
    protected $dates = ['email_verified_at'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function getProfilePictureAttribute()
    {
        return $this->property && $this->property->profile_picture
            ? $this->property->profile_picture
            : null;
    }
    public function getProperNameAttribute()
    {
        return $this->name ?: ($this->property && $this->property->username ?: $this->email);
    }
    public function getProperNameHtmlAttribute()
    {
        return $this->property && $this->property->username ? '@'.$this->property->username : $this->proper_name;
    }
    public function getUrlProfileAttribute()
    {
        return $this->property && $this->property->username
            ? route('user.showAsUsername', ['user' => $this->property->username])
            : route('user.show', ['user' => $this]);
    }
    public function getHasVerifiedEmailAttribute()
    {
        return (bool) $this->email_verified_at;
    }
}