<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $loginUrl = 'login';

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

    /**
     * ログイン時にバリデーションエラーが適切に発生する
     */
    public function testValidation()
    {
        $this->from($this->loginUrl)
            ->post($this->loginUrl, [
                'email'    => '',
                'password' => '',
            ])
            ->assertSessionHasErrors([
                'email'    => 'メールアドレスは必ず指定してください。',
                'password' => 'パスワードは必ず指定してください。',
            ])
            ->assertRedirect($this->loginUrl);

        // DBに登録されていないメールアドレス・パスワードを入力してログインしようとすると、バリデーションエラーが発生することをテスト
        $dbData = [
            'email'    => 'aaa@example.com',
            'password' => 'Test1234',
        ];

        // DBにユーザーを登録
        factory(User::class)->create($dbData);

        $postDataSet = [
            [
                'email'    => 'bbb@example.com', // メールアドレスが間違っている
                'password' => 'Test1234',
            ],
            [
                'email'    => 'aaa@example.com',
                'password' => 'hoge5678', // パスワードが間違っている
            ],
            [
                // メールアドレスもパスワードも両方間違っている
                'email'    => 'bbb@example.com',
                'password' => 'hoge5678',
            ],
        ];

        foreach ($postDataSet as $postData) {
            $this->from($this->loginUrl)
                ->followingRedirects()
                ->post($this->loginUrl, $postData)
                ->assertSee('ログイン情報が登録されていません。');
        }
    }

    /**
     * 一般ユーザーでログインできる
     */
    public function testLogin()
    {
        $this->withoutExceptionHandling();

        $postData = [
            'email'    => 'aaa@example.com',
            'password' => 'Test1234',
        ];

        $dbData = [
            'email'    => 'aaa@example.com',
            'password' => bcrypt('Test1234'),
        ];

        $user = factory(User::class)->create($dbData);

        // ログインに成功したら、ホーム画面に遷移すべき
        $this->post($this->loginUrl, $postData)
            ->assertRedirect(RouteServiceProvider::HOME);

        // フラッシュメッセージをチェック
        $this->get(route('articles.index'))
            ->assertSee('ログインしました');

        // 指定したユーザーが認証されているべき
        $this->assertAuthenticatedAs($user);

        // ログイン後にログイン画面にアクセスしようとすると、ホーム画面にリダイレクトされるべき
        $this->get($this->loginUrl)
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * かんたんログインできる
     */
    public function testGuestLogin()
    {
        // ゲストログイン用のユーザーを作成
        factory(User::class)->create([
            'id'       => config('user.guest_user.id'),
            'name'     => config('user.guest_user.name'),
            'email'    => config('user.guest_user.email'),
            'password' => bcrypt(config('user.guest_user.password')),
        ]);

        // かんたんログインに成功したら、ホーム画面に遷移すべき
        $this->get(route('guest.login'))
            ->assertRedirect(RouteServiceProvider::HOME);

        // フラッシュメッセージをチェック
        $this->get(route('articles.index'))
            ->assertSee('ゲストユーザーでログインしました');

        // ログイン後にログイン画面にアクセスしようとすると、ホーム画面にリダイレクトされるべき
        $this->get($this->loginUrl)
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * ログアウトできる
     */
    public function testLogout()
    {
        $this->login();

        // ログアウトに成功したら、ホーム画面に遷移すべき
        $this->post(route('logout'))
            ->assertRedirect(RouteServiceProvider::HOME);

        // フラッシュメッセージをチェック
        $this->get(route('articles.index'))
            ->assertSee('ログアウトしました');

        // ユーザーが認証されていないべき
        $this->assertGuest();
    }
}
