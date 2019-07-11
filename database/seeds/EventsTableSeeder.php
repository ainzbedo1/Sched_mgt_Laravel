<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_categories')->insert([
            'ev_category_name' => "Personal",
        ]);
        DB::table('event_categories')->insert([
            'ev_category_name' => "Family",
        ]);
        DB::table('event_categories')->insert([
            'ev_category_name' => "Business",
        ]);
        DB::table('event_categories')->insert([
            'ev_category_name' => "Work",
        ]);
        DB::table('events')->insert([
            'event_name' => str_random(10),
            'event_desc' => str_random(20),
            'event_status' => rand(0,2),
            'event_start' => now(),
            'event_finish' => now(),
            'evcat_id' => 1,
            'user_id' => 1
        ]);
        DB::table('users')->insert([
            'name'    => "John Doe",
            'username'    => "John",
            'email'    => "sample@example.com",
            'password'   =>  Hash::make('123'),
            'remember_token' =>  str_random(10),
        ]);

        Eloquent::unguard();
        $this->call(UsersTablesSeeder::class);
    }
}
