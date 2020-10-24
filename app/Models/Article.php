<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * articles
 * 
 * 기사 (URL) 콘텐츠 하나하나
 */
class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'url', 'title', 'summary', 'thumbnail',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function vendor()
    {
        return $this->hasManyThrough(Vendor::class, VendorArticle::class, 'vendor_id');
    }
}