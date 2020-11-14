<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    ### 投稿一覧表示機能のテスト ###

    // 未ログイン時
    public function testGuestIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
        ->assertViewIs('articles.index')
        ->assertSee('ユーザー登録')
        ->assertSee('ログイン')
        ->assertSee('かんたんログイン');
    }

    // ログイン時
    public function testAuthIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->get(route('articles.index'));

        $response->assertStatus(200)
        ->assertViewIs('articles.index')
        ->assertSee('投稿する')
        ->assertSee($user->name . 'さん')
        ->assertSee('新規投稿');
    }


    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect('login');
    }

    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->get(route('articles.create'));

        $response->assertStatus(200)
        ->assertViewIs('articles.create');
    }
}
