<?php

namespace Tests\Feature\Listeners;

use Gamify\Enums\BadgeActuators;
use Gamify\Listeners\IncrementBadgesOnUserLogin;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncrementBadgeOnUserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_increments_badges_with_OnUserLogin_actuator()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnUserLogin,
        ]);

        $event = \Mockery::mock(Login::class);
        $event->user = $user;

        $listener = app()->make(IncrementBadgesOnUserLogin::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_without_OnUserLogin_actuator()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::None,
        ]);

        $event = \Mockery::mock(Login::class);
        $event->user = $user;

        $listener = app()->make(IncrementBadgesOnUserLogin::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }
}
