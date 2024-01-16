<?php

namespace App\Console\Commands;

use App\Library\Shiprocket;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class Runner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        dd((new Shiprocket())->getUserDetails([1]));
        $user = User::query()->first();
        $role = Role::query()->where("key", 'admin')->first();

        if ($role != null)
        {
            $user->roles()->attach($role->id);
        }
    }
}
