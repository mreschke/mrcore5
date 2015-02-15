<?php

use Mrcore\WorkbenchFramework\User;

class WorkbenchFrameworkUserSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        // 1 Anonymous User
        User::create(array(
            'uuid'     => \Mrcore\Helpers\String::getGuid(),
            'email'    => 'anonymous@anonymous.com',
            'password' => Hash::make(md5(microtime())),
            'first'    => 'Anonymous',
            'last'     => 'Anonymous',
            'alias'    => 'anonymous',
            'avatar'   => 'avatar_user1.png',
            'global_post_id' => null,
            'home_post_id'   => null,
            'login_at'  => '1900-01-01 00:00:00',
            'disabled'       => true
        ));

    }

}
