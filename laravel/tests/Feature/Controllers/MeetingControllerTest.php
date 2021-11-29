<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetingControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $loginUrl = 'login';

    /**
     * 未ログインのユーザーはリダイレクトされるべき
     */
    public function testGuestRedirect()
    {
        $meeting = factory(Meeting::class)->create();

        // ミーティング一覧画面の表示
        $this->get(route('meetings.index'))
            ->assertRedirect($this->loginUrl);

        // ミーティング作成画面の表示
        $this->get(route('meetings.create'))
            ->assertRedirect($this->loginUrl);

        // ミーティング編集画面の表示
        $this->get(route('meetings.edit', compact('meeting')))
            ->assertRedirect(route($this->loginUrl));
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

    // ログイン時
    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('meetings.create'));

        $response->assertStatus(200)
            ->assertViewIs('meetings.create');
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
