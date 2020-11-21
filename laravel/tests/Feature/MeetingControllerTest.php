<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetingControllerTest extends TestCase
{
    use RefreshDatabase;

    ### ミーティング一覧表示機能のテスト ###

    // 未ログイン時
    public function testGuestIndex()
    {
        $response = $this->get(route('meetings.index'));

        $response->assertRedirect(route('login'));
    }

    // ログイン時
    public function testAuthIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->get(route('meetings.index'));

        $response->assertStatus(200)
        ->assertViewIs('meetings.index');
    }

    ### ミーティング投稿画面 表示機能のテスト ###

    // 未ログイン時
    public function testGuestCreate()
    {
        $response = $this->get(route('meetings.create'));

        $response->assertRedirect(route('login'));
    }

    // ログイン時
    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->get(route('meetings.create'));

        $response->assertStatus(200)
        ->assertViewIs('meetings.create');
    }

    ### 投稿の編集画面 表示機能のテスト ###

    // 未ログイン時
    public function  testGuestEdit()
    {
        $meeting = factory(Meeting::class)->create();

        $response = $this->get(route('meetings.edit', ['meeting' => $meeting]));
        $response->assertRedirect(route('login'));
    }

    // ログイン時
    public function testAuthEdit()
    {
        $this->withoutExceptionHandling();
        $meeting = factory(Meeting::class)->create();
        $user = $meeting->user;

        $response = $this->actingAs($user)->get(route('meetings.edit', ['meeting' => $meeting]));

        $response->assertStatus(200)->assertViewIs('meetings.edit');
    }
}
