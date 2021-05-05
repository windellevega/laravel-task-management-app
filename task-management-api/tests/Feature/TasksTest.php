<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Exception;
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

        $token = $user->createToken($user->email)->plainTextToken;

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

        $token = $user->createToken($user->email)->plainTextToken;

        try{
            $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->postJson('api/tasks');
        }
        catch (Throwable $e) {
            $this->assertEquals(new HttpException(403), $e);
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
        
        $task = [
            'title' => 'Sample task'
        ];

        $token = $user->createToken($user->email)->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('api/tasks', $task)
            ->assertStatus(201);
            
    }

    /**
     * 
     * Test feature GET api/tasks/{task}
     *
     * @test
     */
    public function user_can_view_task_assigned_or_created()
    {
        $user = User::where('email', 'admin@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('api/tasks/1')
            ->assertJsonStructure(['id', 'title', 'user_id']);
            
    }

    /**
     * 
     * Test feature GET api/tasks/{task}
     *
     * @test
     */
    public function user_cannot_view_task_not_assigned_or_not_created()
    {
        $user = User::where('email', 'johndoe@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        try{
            $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->getJson('api/tasks/1')
                ->assertStatus(200);
        }
        catch (Throwable $e) {
            $this->assertEquals(new HttpException(403), $e);
        }   
    }

    /**
     * 
     * Test feature PUT api/tasks/{task}
     *
     * @test
     */
    public function admin_can_update_task()
    {   
        $update = [
            'title'             => 'Updated task',
            'assigned_to_id'    => 5
        ];

        $task = Task::first();
        $task->title = 'Updated task';
        $task->assigned_to_id = 5;

        $user = User::where('email', 'admin@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        $result = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                    ->putJson('api/tasks/1', $update)
                    ->content();
        
        $this->assertEquals($task, $result);
    }

    /**
     * 
     * Test feature PUT api/tasks/{task}
     *
     * @test
     */
    public function non_admin_user_cannot_update_task()
    {   
        $update = [
            'title'             => 'Updated task',
            'assigned_to_id'    => 5
        ];

        $user = User::where('email', 'johndoe@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        try {
            $result = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                    ->putJson('api/tasks/1', $update)
                    ->assertStatus(200);
        }
        catch(Exception $e) {
            $this->assertEquals(new HttpException(403), $e);
        }
    }

    /**
     * 
     * Test feature DELETE api/tasks/{task}
     *
     * @test
     */
    public function admin_can_delete_task()
    {   
        $user = User::where('email', 'admin@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                    ->deleteJson('api/tasks/1')
                    ->assertStatus(200);
    }

    /**
     * 
     * Test feature DELETE api/tasks/{task}
     *
     * @test
     */
    public function non_admin_user_cannot_delete_task()
    {   
        $user = User::where('email', 'johndoe@example.com')
                    ->first();

        $token = $user->createToken($user->email)->plainTextToken;

        try {
            $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                    ->deleteJson('api/tasks/1')
                    ->assertStatus(403);
        }
        catch(Exception $e) {
            $this->assertEquals(new HttpException(403), $e);
        }
    }
}
