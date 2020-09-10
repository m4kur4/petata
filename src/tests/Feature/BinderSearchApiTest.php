<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderFavorite;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderSearchApiTest extends TestCase
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
     * 検索条件を指定しない場合のテスト
     * TODO:
     * 自分自身のバインダーを検索するテスト
     * 他人が作成したバインダーを検索するテスト
     * お気に入り登録しているバインダーを検索するテスト
     * バインダー名が前方一致するバインダーを検索するテスト
     * 
     * - ログインユーザーがアクセス可能な全てのバインダーを取得すること
     */
    public function Binder_Search_Success_ALL()
    {
        $this->actingAs($this->user);

        $MY_BINDER_COUNT = 5;
        $OTHER_BINDER_COUNT = 15;

        factory(Binder::class, $MY_BINDER_COUNT)->create([
            'create_user_id' => $this->user->id
        ]);

        factory(Binder::class, $OTHER_BINDER_COUNT)->create();
        $request = [];

        // 検証
        $response = $this->json('GET', route('api.binder.search', $request));

        $response->assertStatus(200);

    }

}
