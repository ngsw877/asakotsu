<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * ログイン画面を開ける
     *
     * @see \App\Http\Controllers\Auth\LoginController
     */
    public function testShowLoginForm()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }
}
