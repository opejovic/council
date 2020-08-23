<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Activity extends Model
{
    /**
     * Attributes that are not mass assignable.
     */
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50)
    {
        return $user->activity()
                ->latest()
                ->with('subject')
                ->take($take)
                ->get()
                ->groupBy(function ($activity) {
                    return $activity->created_at->format('d.m.Y');
                });
    }
}
