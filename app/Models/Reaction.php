<?php
namespace App\Models;

use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * reactions
 * 
 * 댓글에 달리는 반응 하나하나
 */
class Reaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'comment_id', 'reaction',
    ];
    public $reaction_options = [
        '👍', '❤', '😂', '👏', '🙏',
        '🤯', '😢', '🤔',
        '🤬', '👎',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function getHtmlRadioOptionsAttribute()
    {
        $options = collect($this->reaction_options);
        if ($this->comment) {
            $existing_reactions = $this->comment->reactions->pluck('reaction');
            $options = $options->merge($existing_reactions)->unique()->values();
        }

        return $options->transform(function ($option) {
            $random_id = 'reaction_'.random_int(1, 99999);
            return
            '<div class="form-check form-check-inline">
                <input id="'.$random_id.'" type="radio" name="reaction" value="'.$option.'" class="form-check-input" />
                <label class="form-check-label" for="'.$random_id.'">'.$option.'</label>
            </div>';
        })->implode('');
    }
}