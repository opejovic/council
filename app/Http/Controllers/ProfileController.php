<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activity()->latest()->with('subject')->get()->groupBy(function ($activity) {
            return $activity->created_at->format('d.m.Y');
        });

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities
        ]);
    }
}
