<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use Hash;

/**
 * ユーザー登録APIテスト
 */
class UserRegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * 
     * 新規作成が成功する。
     */
    public function User_Create_Success()
    {
        $form_data = [
            'name' => 'test user',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', route('api.user.register'), $form_data);

        // 検証
        $user = User::first();

        // - 入力値がテーブルに反映されていることを確認
        $this->assertEquals($form_data['name'], $user->name);
        $this->assertEquals($form_data['email'], $user->email);
        $this->assertTrue(Hash::check($form_data['password'], $user->password));

        // - ステータスコードと戻り値が期待通りであることを確認
        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name]);
    }

    /**
     * @test
     * 
     * パスワードの入力確認で不一致の場合に新規作成失敗。
     */
    public function User_Create_Failer4ConfirmPasswordError()
    {
        $form_data = [
            'name' => 'test user',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password2222',
        ];

        $response = $this->json('POST', route('api.user.register'), $form_data);

        $response->assertStatus(422);
    }
}
