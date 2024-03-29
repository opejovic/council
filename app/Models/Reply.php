<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    /**
     * Attributes that are not mass assignable.
     */
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function getOwnerNameAttribute()
    {
        return $this->owner->name;
    }

    public function path()
    {
        return "{$this->thread->path()}#reply-{$this->id}";
    }

}
