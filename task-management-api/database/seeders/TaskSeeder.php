<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory(15)->create();
        Checklist::factory(50)->create();

        Checklist::all()->each(function ($checklist) {
            $checklist->statusHistory()->attach(1, ['remarks' => 'Checklist has been created.']);
        });
    }
}
