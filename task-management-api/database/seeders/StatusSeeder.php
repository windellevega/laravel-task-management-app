<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['status_name' => 'Created'],
            ['status_name' => 'Started'],
            ['status_name' => 'Paused'],
            ['status_name' => 'Finished']
        ];

        Status::insert($statuses);
    }
}
