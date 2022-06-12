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
    public function test_store_a_task()
    {
        $attributes = factory(Task::class)->make();
        $this->actingAs(User::first())
            ->post(route('task.store') , $attributes->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('tasks' , $attributes->toArray());
    }

    public function test_store_validation()
    {
        $this->actingAs(User::first())
            ->post(route('task.store'))
            ->assertSessionHasErrors(['title','description'])
            ->assertStatus(302);
    }
}
