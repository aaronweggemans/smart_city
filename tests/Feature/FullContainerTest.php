<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use RoleSeeder;
use Tests\TestCase;

class FullContainerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Checks if it is possible to reach this page without permission.
     * The user needs to be logged in to reach this page and this test will check it
     */
    public function only_logged_in_users_can_see_the_full_container_page()
    {
        $this->get("/dashboard/full/container")
            ->assertRedirect('/login');
    }

    /**
     * @test
     * Check if the user can reach the page
     */
    public function authenticated_users_can_see_the_full_container_page()
    {
        // Makes sure that the roles are seeded
        $this->seed(RoleSeeder::class);

        // Creates a user
        $fake_admin = User::create([
            'name' => "jan",
            'email' => "janwillem@hotmail.nl",
            'role_id' => 1,
            'city_id' => 0,
            'street_id' => 0,
            'avatar' => '',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Faking a user and acting this user to see route
        $this->actingAs($fake_admin);

        // Check for the route
        $this->get("/dashboard/full/container")
            ->assertOk();
    }

    /**
     * @test
     *
     * Test to make sure that it is possible to delete a container from the firebase database
     * It will check if the authenticated user has the possibility to remove a container
     */
    public function make_sure_a_authenticated_user_can_cleanup_a_container()
    {
        // Makes sure that all roles are inserted in the database
        $this->seed(RoleSeeder::class);

        // Creates a fake user
        $fake_user = User::create([
            'name' => "jan",
            'email' => "janwillem@hotmail.nl",
            'role_id' => 1,
            'city_id' => 0,
            'street_id' => 0,
            'avatar' => '',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Fakes a user acting as
        $this->actingAs($fake_user);

        // Call to the delete response
        $response = $this->delete("/dashboard/full/container/destroy", [
            'street_id' => 0,
            'city_id' => 0
        ]);

        // Checks if the delete response returns us the 302 message (redirection)
        $response->assertStatus(302);
    }

    /**
     * @test
     *
     * This test will check if a user cannot reach the delete call
     */
    public function make_sure_a_unauthenticated_user_cannot_cleanup_a_container()
    {
        // Makes sure that all roles are inserted in the database
        $this->seed(RoleSeeder::class);

        // Creates a fake user
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

        // Fakes a user acting as
        $this->actingAs($fake_user);

        // Call to the delete response
        $response = $this->delete("/dashboard/full/container/destroy", [
            'street_id' => 0,
            'city_id' => 0
        ]);

        // The route isn't there when the users has not the right role.
        // So the expected value is: (404 not found)
        $response->assertStatus(404);
    }
}
