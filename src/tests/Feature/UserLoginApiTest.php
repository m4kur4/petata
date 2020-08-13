<?php

namespace Tests\Feature;

use App\User;

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
     * 正しい認証情報を送信し、ログインに成功する。
     */
    public function User_Login_Success()
    {
        $formData = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $response = $this->json('POST', route('api.user.login'), $formData);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($this->user);
    }
}
