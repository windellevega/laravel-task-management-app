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
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->userToken])
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
        try{
            $this->withHeaders(['Authorization' => 'Bearer ' . $this->userToken])
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

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
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
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
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
        try{
            $this->withHeaders(['Authorization' => 'Bearer ' . $this->userToken])
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

        $result = $this->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
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

        try {
            $result = $this->withHeaders(['Authorization' => 'Bearer ' . $this->userToken])
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
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
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
        try {
            $this->withHeaders(['Authorization' => 'Bearer ' . $this->userToken])
                    ->deleteJson('api/tasks/1')
                    ->assertStatus(403);
        }
        catch(Exception $e) {
            $this->assertEquals(new HttpException(403), $e);
        }
    }
}
