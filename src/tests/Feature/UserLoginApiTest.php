<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Hash;

class UserLoginApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * ログインに成功する場合のテスト
     * 
     * - 正しい認証情報でユーザーがログインできること
     */
    public function User_Login_Success()
    {
        $form_data = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $response = $this->json('POST', route('api.user.login'), $form_data);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($this->user);
    }
}
