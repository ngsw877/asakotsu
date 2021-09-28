<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $loginUrl = 'login';

    /**
     * 未ログインのユーザーはリダイレクトされるべき
     */
    public function testGuestRedirect()
    {
        $article = factory(Article::class)->create();

        // 新規投稿画面の表示
        $this->get(route('articles.create'))
            ->assertRedirect($this->loginUrl);

        // 新規投稿処理
        $this->post(route('articles.store'))
            ->assertRedirect($this->loginUrl);

        // 編集画面の表示
        $this->get(route('articles.edit', compact('article')))
            ->assertRedirect($this->loginUrl);

        // 投稿の更新処理
        $this->patch(route('articles.update', compact('article')))
            ->assertRedirect($this->loginUrl);

        // 投稿の削除処理
        $this->delete(route('articles.destroy', compact('article')))
            ->assertRedirect($this->loginUrl);
    }

    /**
     * 投稿一覧画面が開ける
     * （未ログイン時用）
     */
    public function testGuestIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index')
            ->assertSee('ユーザー登録')
            ->assertSee('ログイン')
            ->assertSee('かんたんログイン');
    }

    /**
     * 投稿一覧画面が開ける
     * （ログイン時用）
     */
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

    /**
     * 新規投稿画面が開ける
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }

    /**
     * 新規投稿ができる
     */
    public function testStore()
    {
        $user = $this->login();

        // 正常な投稿データ
        $validData = [
            'body'       => 'テスト投稿です',
            'user_id'    => $user->id,
            'ip_address' => Request::ip(),
        ];

        // 新規投稿
        $response = $this->post(route('articles.store'), $validData);

        // articlesテーブルに、POSTしたデータが登録されているべき
        $this->assertDatabaseHas('articles', $validData);

        $response->assertRedirect(route('articles.index'));
    }

    /**
     * 投稿の編集画面を開ける
     */
    public function testEdit()
    {
        $this->withoutExceptionHandling();
        $article = factory(Article::class)->create();
        $user = $article->user;

        $response = $this->actingAs($user)->get(route('articles.edit', ['article' => $article]));

        $response->assertStatus(200)->assertViewIs('articles.edit');
    }

    /**
     * 投稿を削除できる
     */
    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        $user = $this->login();

        // 投稿のテストデータを作成
        $article = factory(Article::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete(route('articles.destroy', compact('article')));

        // 投稿のテストデータがDBから削除(論理削除)されているべき
        $this->assertSoftDeleted('articles', [
            'id'         => $article->id,
            'body'       => $article->body,
            'user_id'    => $article->user_id,
            'ip_address' => $article->ip_address,
        ]);

        $response->assertRedirect(route('articles.index'));
    }
}
