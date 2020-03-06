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

use Faker\Generator as Faker;
use Gamify\Badge;
use Gamify\QuestionAction;

// To create a user with fake information
$factory->define(QuestionAction::class, function (Faker $faker) {
    return [
        'when' => $faker->randomElement([QuestionAction::ON_ANY_CASE, QuestionAction::ON_SUCCESS, QuestionAction::ON_FAILURE]),
        'badge_id' => function () {
            return factory(Badge::class)->create()->id;
        },
    ];
});
