<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use RoleSeeder;
use Tests\TestCase;
use UserSeeder;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Test if the page is reachable
     */
    public function make_sure_it_is_possible_to_see_the_landing_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * Checks if a authenticated user can reach the landing page
     */
    public function make_sure_it_is_possible_to_see_the_landing_page_when_authorized()
    {
        // Makes sure that all roles are inserted in the database
        $this->seed(RoleSeeder::class);

        // Creates a user
        $fake_user = User::create([
            'name' => "jan",
            'email' => "janwillem@hotmail.nl",
            'role_id' => 2,
            'city_id' => 0,
            'street_id' => 0,
            'avatar' => '',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Acting as this user
        $this->actingAs($fake_user);

        // Checks the route
        $response = $this->get('/');

        // Returns ok
        $response->assertOk();
    }

    /**
     * @test
     *
     * Defines the login page and when logging in the authentication will fail when user is not found
     * with the correct data inserted
     */
    public function make_sure_login_will_fail_when_incorrect_email_or_password()
    {
        // Seeding your local database
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);

        // Call to the post response of login
        $response = $this->post("/login", [
            'email' => "aaronweggemans@hotmail.nl",
            'password' => str::random(10)
        ]);

        // Checks if the page redirects if user is not correct logged in
        $response->assertStatus(302);
    }
}
