<?php

use App\Chat;
use Illuminate\Database\Seeder;

class DefaultChat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chat::firstOrCreate([
            Chat::SLUG => 'default',
        ]);
    }
}
