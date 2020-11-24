<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    ### ユーザープロフィール編集画面 表示機能のテスト ###

    // 未ログイン時
    public function  testGuestEdit()
    {
        $user = factory(User::class)->create();

        $response = $this->get(route('users.edit', ['name' => $user->name]));
        $response->assertRedirect(route('login'));
    }

    // ログイン時
    public function testAuthEdit()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('users.edit', ['name' => $user->name]));

        $response->assertStatus(200)->assertViewIs('users.edit');
    }
}
