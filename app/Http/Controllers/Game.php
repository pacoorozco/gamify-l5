<?php

namespace Gamify\Http\Controllers;

use Gamify\User;
use Gamify\Badge;
use Gamify\Point;
use Carbon\Carbon;

class Game extends Controller
{
    /**
     * Add experience to an user.
     *
     * @param User   $user
     * @param int    $points
     * @param string $message
     *
     * @return bool
     */
    public static function addExperience(User $user, $points = 5, $message = '')
    {
        if (empty($message)) {
            $message = trans('messages.unknown_reason');
        }

        // add experience points to this user
        $point_entry = new Point([
            'points'      => $points,
            'description' => $message,
        ]);

        return is_null($user->points()->save($point_entry)) ? false : true;
    }

    /**
     * Give one more action towards a Badge for an User.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return bool
     */
    public static function incrementBadge(User $user, Badge $badge)
    {
        if ($userBadge = $user->badges()->find($badge->id)) {
            // this badge was initiated before
            $userBadge->pivot->repetitions++;
            if ($userBadge->pivot->repetitions == $badge->required_repetitions) {
                $userBadge->pivot->completed = true;
                $userBadge->pivot->completed_on = Carbon::now();
            }
            $saved = $userBadge->pivot->save();
        } else {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, ['repetitions' => '1']);
            $saved = true;
        }

        return $saved;
    }

    /**
     * Give a completed Badge for an User.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return bool
     */
    public static function addBadge(User $user, Badge $badge)
    {
        if ($user->hasBadgeCompleted($badge)) {
            return true;
        }

        $data = [
            'repetitions'  => $badge->required_repetitions,
            'completed'    => true,
            'completed_on' => Carbon::now(),
        ];

        if ($userBadge = $user->badges()->find($badge->id)) {
            // this badge was initiated before
            $saved = $userBadge->pivot->save($data);
        } else {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, $data);
            $saved = true;
        }

        return $saved;
    }

    /**
     * Get a collection with members ordered by Experience Points.
     *
     * @param int $limitTopUsers
     *
     * @return mixed
     */
    public static function getRanking($limitTopUsers = 10)
    {
        $users = User::Member()->with('points')->get();

        $users = $users->sortByDesc(function ($user) {
            return $user->getExperiencePoints();
        })->take($limitTopUsers);

        return $users;
    }
}
