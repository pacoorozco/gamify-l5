<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

return [

    'already_exists'          => 'User already exists!',
    'does_not_exist'          => 'User does not exist.',
    'login_required'          => 'The login field is required',
    'password_required'       => 'The password is required.',
    'password_does_not_match' => 'The passwords provided do not match.',
    'roles_help'          => 'Select a role to assign to the user, remember that a user takes on the permissions of the role they are assigned.',

    'create' => [
        'error'   => 'User was not created, please try again.',
        'success' => 'User created successfully.',
    ],

    'edit' => [
        'impossible' => 'You cannot edit yourself.',
        'error'      => 'There was an issue editing the user. Please try again.',
        'success'    => 'The user was edited successfully.',
    ],

    'delete' => [
        'impossible' => 'You cannot delete yourself.',
        'error'      => 'There was an issue deleting the user. Please try again.',
        'success'    => 'The user was deleted successfully.',
    ],

];
