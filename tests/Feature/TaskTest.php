<?php
namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_a_user()
    {
        $attributes = factory(Task::class)->create();
        $response = $this->actingAs(User::first())
            ->post('/task' , $attributes->toArray())
            ->assertStatus(200);
        $this->assertDatabaseHas('tasks' , $attributes->toArray());
        $response->assertSee($attributes['title']);
    }
}
