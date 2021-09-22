<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $loginUrl = 'login';

        $this->from($loginUrl)
            ->post($loginUrl, [])
            ->assertRedirect($loginUrl);

        $this->post($loginUrl, ['email' => ''])->assertSessionHasErrors(['email' => 'メールアドレスは必ず指定してください。']);
        $this->post($loginUrl, ['password' => ''])->assertSessionHasErrors(['password' => 'パスワードは必ず指定してください。']);


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
            $this->from($loginUrl)
                ->followingRedirects()
                ->post($loginUrl, $postData)
                ->assertSee('ログイン情報が登録されていません。');
        }
    }
}
