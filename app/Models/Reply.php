<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;

class Reply extends Model
{
    use Favoritable;

    /**
     * Attributes that are not mass assignable.
     */
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

}
