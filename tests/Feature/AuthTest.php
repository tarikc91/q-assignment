<?php

namespace Tests\Feature;

use App\Clients\Qss\Client;
use Mockery;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_it_shows_the_login_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }
}
