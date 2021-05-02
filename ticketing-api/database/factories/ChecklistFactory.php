<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'checklist_name' => $this->faker->sentence(),
            'task_id' => rand(1, Task::count())
        ];
    }
}
