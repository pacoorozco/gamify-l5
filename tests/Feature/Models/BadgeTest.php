<?php

namespace Tests\Feature\Models;

use Gamify\Badge;
use Gamify\Enums\BadgeActuators;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_default_image_when_field_is_empty()
    {
        $badge = factory(Badge::class)->create();

        $this->assertNull($badge->getOriginal('image_url'));
    }

    /** @test */
    public function it_returns_actuators_as_enum_when_model_is_read_from_database()
    {
        $want = factory(Badge::class)->create();
        $want->actuators = BadgeActuators::OnUserLogin();
        $want->saveOrFail();

        $got = Badge::find($want)->first();

        $this->assertEquals(BadgeActuators::OnUserLogin(), $got->actuators);
    }
}
