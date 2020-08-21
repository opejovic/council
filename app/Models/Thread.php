<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['category', 'creator'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function path()
    {
        return "/threads/{$this->category->slug}/{$this->id}";
    }

    public function addReply($attributes)
    {
        return $this->replies()->create($attributes);

    }

    public function getCreatorNameAttribute()
    {
        return $this->creator->name;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
