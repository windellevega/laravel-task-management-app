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
    public function testNonAdminUserCanRetrieveTasksGiven()
    {
        $token = $this->login('johndoe@example.com', 'password');
        
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
    public function testNonAdminUserCannotCreateTask()
    {
        $token = $this->login('johndoe@example.com', 'password');

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
    public function testAdminUserCanCreateTask()
    {
        $task = [
            'title' => 'Sample task'
        ];

        $token = $this->login('admin@example.com', 'password');

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
    public function testAdminUserCanViewTaskAssignedOrCreated()
    {
        $token = $this->login('admin@example.com', 'password');

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
    public function testUserCannotViewTaskNotAssignedOrNotCreated()
    {
        $token = $this->login('johndoe@example.com', 'password');

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
    public function testAdminUserCanUpdateTask()
    {   
        $update = [
            'title'             => 'Updated task',
            'assigned_to_id'    => 5
        ];

        $task = Task::first();
        $task->title = 'Updated task';
        $task->assigned_to_id = 5;

        $token = $this->login('admin@example.com', 'password');

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
    public function testNonAdminUserCannotUpdateTask()
    {   
        $update = [
            'title'             => 'Updated task',
            'assigned_to_id'    => 5
        ];

        $token = $this->login('johndoe@example.com', 'password');

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
    public function testAdminUserCanDeleteTask()
    {   
        $token = $this->login('admin@example.com', 'password');

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
    public function testNonAdminUserCannotDeleteTask()
    {   
        $token = $this->login('johndoe@example.com', 'password');

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
