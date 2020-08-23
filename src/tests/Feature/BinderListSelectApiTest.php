<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BinderListSelectApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->binder_list_select_service = app()->make(BinderListSelectServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * ユーザーがアクセス可能なバインダーだけを取得する。
     */
    public function Binders_Get_OnlyAccessible()
    {
        $this->actingAs($this->user);

        // アクセス可能なバインダー数
        $ACCESSIBLE_COUNT = 10;
        // アクセス不可のバインダー数
        $UNACCESSIBLE_COUNT = 5;

        // バインダーを作成
        $accessible_binders = factory(Binder::class, $ACCESSIBLE_COUNT)->create();
        $unaccessible_binders = factory(Binder::class, $UNACCESSIBLE_COUNT)->create();

        // 規定のバインダーに対してテストユーザーのアクセス権を付与
        foreach($accessible_binders as $binder) {
            $param = [
                'user_id' => $this->user->id,
                'binder_id' => $binder->id
            ];
            factory(BinderAuthority::class)->create($param);
        }

        // 検証
        $response = $this->json('GET', route('api.binder.list'));
        
        $response->assertStatus(200);

    }


}
