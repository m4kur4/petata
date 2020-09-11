<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     * 
     * ログアウトに成功する場合のテスト
     * 
     * - ユーザーがログアウトされること
     */
    public function User_Logout_Success()
    {
        $this->actingAs($this->user);
        $response = $this->json('POST', route('api.user.logout'));

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
