<?php

namespace Tests\Feature;

use App\Models\Article;
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


    ### 投稿画面表示機能のテスト ###

    // 未ログイン時
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect('login');
    }

    // ログイン時
    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->get(route('articles.create'));

        $response->assertStatus(200)
        ->assertViewIs('articles.create');
    }


    ### 投稿機能のテスト ###

    // 未ログイン時
    public function testGuestStore()
    {
        $response = $this->post(route('articles.store'));

        $response->assertRedirect('login');
    }

    // ログイン時
    public function testAuthStore()
    {
        // テストデータをDBに保存
        $user = factory(User::class)->create();

        $body = "テスト本文";
        $user_id = $user->id;

        $response = $this->actingAs($user)
        ->post(route('articles.store',
        [
            'body' => $body,
            'user_id' => $user_id,
            ]
        ));

        // テストデータがDBに登録されているかテスト
        $this->assertDatabaseHas('articles', [
            'body' => $body,
            'user_id' => $user_id
        ]);

        $response->assertRedirect(route('articles.index'));
    }

    ### 投稿の編集画面 表示機能のテスト ###

    // 未ログイン時
    public function  testGuestEdit()
    {
        $article = factory(Article::class)->create();

        $response = $this->get(route('articles.edit', ['article' => $article]));
        $response->assertRedirect(route('login'));
    }

    // ログイン時
    public function testAuthEdit()
    {
        $this->withoutExceptionHandling();
        $article = factory(Article::class)->create();
        $user = $article->user;

        $response = $this->actingAs($user)->get(route('articles.edit', ['article' => $article]));

        $response->assertStatus(200)->assertViewIs('articles.edit');
    }

    ### 投稿削除機能のテスト ###
    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        // テストデータをDBに保存
        $user = factory(User::class)->create();

        $body = "テスト本文";
        $user_id = $user->id;

        $article = Article::create([
            'body' => $body,
            'user_id' => $user->id,
            ]);

        // DBからテストデータを削除
        $response = $this->actingAs($user)->delete(route('articles.destroy', ['article' => $article]));

        // テストデータがDBから削除されているかテスト
        $this->assertDeleted('articles', [
            'body' => $body,
            'user_id' => $user_id
        ]);

        $response->assertRedirect(route('articles.index'));
    }
}

