<?php

namespace Tests\Feature;

use App\User;
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
        $formData = [
            'name' => 'test user',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', route('user.register'), $formData);

        $user = User::first();
        $this->assertEquals($formData['name'], $user->name);
        $this->assertEquals($formData['email'], $user->email);
        $this->assertTrue(Hash::check($formData['password'], $user->password));

        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name]);
    }

    /**
     * @test
     * 
     * パスワードの入力確認が不一致の場合に新規作成失敗。
     */
    public function User_Create_Failer4ConfirmPassword()
    {
        $formData = [
            'name' => 'test user',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password2222',
        ];

        $response = $this->json('POST', route('user.register'), $formData);

        $response
            ->assertStatus(422);
    }
}
