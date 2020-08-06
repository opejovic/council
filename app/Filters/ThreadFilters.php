<?php

namespace App\Filters;

use App\Models\User;
use App\Filters\Filters;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popularity'];

    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    public function popularity()
    {
        if (request('popularity') != 1) return;
        
        return $this->builder->orderBy('replies_count', 'desc');
    }
}