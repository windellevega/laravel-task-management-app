<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use Throwable;

class TasksTest extends TestCase
{
    /**
     * 
     * Test feature GET api/tasks
     *
     * @test
     */
    public function a_user_can_retrieve_tasks_given()
    {
        $user = User::where('email', 'johndoe@example.com')
                    ->first();

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('api/tasks')
            ->assertStatus(200);
            
    }

    /**
     * 
     * Test feature POST api/tasks
     *
     * @test
     */
    public function non_admin_user_cannot_create_task()
    {
        $user = User::where('email', 'johndoe@example.com')
                    ->first();

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        try{
            $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->postJson('api/tasks');
        }
        catch (Throwable $e) {
            $this->assertEquals(new HttpException(403, 'Unauthorized action.'), $e);
        }
            
    }

    /**
     * 
     * Test feature POST api/tasks
     *
     * @test
     */
    public function admin_user_can_create_task()
    {
        $user = User::where('email', 'admin@example.com')
                    ->first();

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('api/tasks')
            ->assertStatus(200);
            
    }
}
