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
        $users = factory(App\User::class, 25)->create(); /** We create 25 users and we asign then to a variable**/
        $users->each(function(App\User $user) use($users){  /**Per each users we create 20 messages**/
        $messages = factory(App\Message::class)
            ->times(20)
            ->create([
                'user_id' => $user->id,
            ]);

        $messages->each(function (App\Message $message) use ($users) {
            factory(App\Response::class, random_int(1, 10)) ->create([
                'message_id' => $message->id,
                'user_id' => $users->random(1)->first()->id, 
            ]);
        });
        $user->follows()->sync(
            $users->random(10)/** A collection random**/
        );
        });
    }
}
