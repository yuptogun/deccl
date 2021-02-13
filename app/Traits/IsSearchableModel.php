<?php
namespace App\Traits;

/**
 * public $searchable = ['foo', 'bar', ...] 속성을 잡아주면 거길 검색할 수 있게 함
 * 
 * @author yuptogun <eojin1211@hanmail.net>
 */
trait IsSearchableModel
{
    /**
     * 검색 가능한 필드들을 모두 뒤짐
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            foreach ($this->searchable as $i => $field) {
                $i == 0
                    ? $q->where($field, 'like', "%$search%")
                    : $q->orWhere($field, 'like', "%$search%");
            }
        });
    }
}