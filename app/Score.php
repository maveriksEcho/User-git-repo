<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Score
 * @package App
 * @property int id
 * @property int user_id
 * @property int repo_id
 * @property boolean score
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static Builder where($a, $b = '', $c = '')
 * @method static Builder select(array $array)
 */
class Score extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'repo_id', 'score',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
