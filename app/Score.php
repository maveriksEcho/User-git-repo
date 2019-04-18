<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
