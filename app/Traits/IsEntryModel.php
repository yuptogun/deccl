<?php
namespace App\Traits;

use Carbon\Carbon;

trait IsEntryModel
{
    /**
     * 최근 $days 일간의 것으로 제한하는 스코프
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param integer $days 값을 주지 않으면 COMMENT_RECENT_DAYS 환경값 사용. 그마저도 없으면 적용안함
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeRecent($query, $days = null)
    {
        if (!$days) $days = (int) env('COMMENT_RECENT_DAYS');

        return (int) $days > 0
            ? $query->where('created_at', '>=', Carbon::now()->startOfDay()->subDays($days))
            : $query;
    }
}