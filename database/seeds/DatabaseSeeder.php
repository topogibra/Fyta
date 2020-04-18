<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
        Eloquent::unguard();

        $path = 'resources/sql/seed.sql';
        DB::unprepared(file_get_contents($path));
        $user = new User();
        $user->username = 'root';
        $user->email = 'root@root.com';
        $user->password_hash = bcrypt('root');
        $user->date = '1920-01-01';
        $user->user_role = 'Manager';
        $user->id_image = 15;
        $user->save();
        $this->command->info('Database seeded!');
     }
}
