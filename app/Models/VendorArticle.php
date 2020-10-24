<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * vendor_article
 * 
 * 언론사-기사 맵핑테이블
 */
class VendorArticle extends Model
{
    use SoftDeletes;

    // protected $table = 'vendor_article';

    protected $fillable = [
        'vendor_id', 'article_id', 'article_code',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'vendor_id');
    }
    public function article()
    {
        return $this->hasOne(Article::class, 'article_id');
    }
}