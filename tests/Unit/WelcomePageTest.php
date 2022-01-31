<?php

namespace Tests\Unit;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /** @test */
    public function status_is_okay()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertOk();
    }
}
