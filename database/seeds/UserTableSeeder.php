<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => 'user',
            'role' => User::USER_ROLE,
        ]);
        $user->profile()->save(factory(UserProfile::class)->make());

        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'role' => User::ADMIN_ROLE,
        ]);
        $admin->profile()->save(factory(UserProfile::class)->make());

        // And finally creates 15 normal users with his/her profile
        factory(User::class, 15)->create()->each(function ($u) {
            $u->profile()->save(factory(UserProfile::class)->make());
        });
    }
}
