<?php

namespace Tests\Feature\Unit\Repository;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->repository = app()->make(BinderRepositoryInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * ユーザーがアクセス可能なバインダーだけを取得する。
     */
    public function selectByAuthorizedUserId()
    {
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
        $binders = $this->repository->selectByAuthorizedUserId($this->user->id);

        // - テーブル上のバインダー数
        $this->assertEquals(Binder::all()->count(), ($ACCESSIBLE_COUNT + $UNACCESSIBLE_COUNT));

        // - 抽出件数
        $this->assertEquals($ACCESSIBLE_COUNT, $binders->count());

        //$this->assertEquals($accessible_binders, $binders);
    }

}
