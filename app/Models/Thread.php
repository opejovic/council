<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

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
}
