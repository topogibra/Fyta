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
        $manager = new User();
        $manager->username = 'root';
        $manager->email = 'root@root.com';
        $manager->password_hash = bcrypt('rootroot');
        $manager->date = '1920-01-01';
        $manager->user_role = 'Manager';
        $manager->id_image = 15;
        $manager->save();
        $user = new User();
        $user->username = 'johndoe';
        $user->email = 'john@doe.com';
        $user->address = 'John Doe Village';
        $user->password_hash = bcrypt('johndoe');
        $user->date = '1920-01-01';
        $user->user_role = 'Customer';
        $user->id_image = 15;
        $user->save();
        $this->command->info('Database seeded!');
     }
}
