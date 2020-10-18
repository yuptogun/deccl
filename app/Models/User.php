<?php
namespace App\Models;

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

    public function getHasVerifiedEmailAttribute()
    {
        return (bool) $this->email_verified_at;
    }
}