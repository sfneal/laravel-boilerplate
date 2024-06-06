<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    #[Test]
    public function status_is_okay()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertOk();
    }
}
