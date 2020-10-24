<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * vendors
 * 
 * 언론사 하나하나의 정보
 */
class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'description', 'url', 'pattern',
    ];

    public function articles()
    {
        return $this->hasManyThrough(Article::class, VendorArticle::class, 'article_id', 'vendor_id');
    }
}