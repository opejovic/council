<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_profile_page_should_show_his_username()
    {
        $user = factory(User::class)->create();

        $response = $this->get("profiles/{$user->name}");

        $response->assertSee($user->name);
    }
}
