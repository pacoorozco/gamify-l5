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
 * @link               https://github.com/pacoorozco/gamify-l5
 */

namespace Gamify;

use Carbon\Carbon;
use Gamify\Traits\GamificationTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User model, represents a Gamify user.
 *
 * @property  int    $id                      The object unique id.
 * @property  string $name                    The name of this user.
 * @property  string $username                The username of this user.
 * @property  string $email                   The email address of this user.
 * @property  string $password                Encrypted password of this user.
 * @property  string $role                    Role of the user ['user', 'editor', 'administrator'].
 */
class User extends Authenticatable
{
    use Notifiable;
    use GamificationTrait;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Users have one user "profile".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('Gamify\UserProfile');
    }

    /**
     * Add a mutator to ensure hashed passwords.
     *
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Returns last logged in date in "x ago" format if it has passed less than a month.
     *
     * @return string
     */
    public function getLastLoggedDate(): string
    {
        if (! $this->last_login_at) {
            return 'Never';
        }
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->last_login_at);

        if ($date->diffInMonths() >= 1) {
            return $date->format('j M Y , g:ia');
        }

        return $date->diffForHumans();
    }

    /**
     * Returns a collection of users that are "Members".
     *
     * @param $query
     *
     * @return Collection
     */
    public function scopeMember($query)
    {
        return $query->where('role', '=', 'user');
    }
}
