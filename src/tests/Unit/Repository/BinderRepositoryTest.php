<?php

namespace Tests\Feature\Unit\Repository;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\Label;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Http\Requests\BinderCreateRequest;

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
    }

    /**
     * @test
     * 
     * バインダーを作成する
     */
    public function create()
    {
        $this->actingAs($this->user);

        // ラベル数
        $LABEL_COUNT = 5;
        $label_posts = [];
        for ($i = 0; $i < $LABEL_COUNT; $i++) {
            $label_post = ['name' => sprintf('label_%s', $i), 'description' => sprintf('説明_%s', $i)];
            array_push($label_posts, $label_post);
        }

        $formData = [
            'name' => 'Test Binder',
            'labels' => $label_posts,
        ];
        $request = new BinderCreateRequest($formData);
        $binder = $this->repository->create($request);

        // 検証
        $binder_first = Binder::first();

        // - バインダー情報の確認
        $this->assertEquals($binder_first->id, $binder->id);
        $this->assertEquals($binder_first->name, $binder->name);

        // - 認可情報の確認
        $binder_authority_first = BinderAuthority::first();
        $this->assertEquals($binder_authority_first->level, config('_const.BINDER_AUTHORITY.LEVEL.OWNER'));

        // - ラベルの確認
        $labels = Label::all();
        $this->assertEquals($labels->count(), $LABEL_COUNT);
        $this->assertEquals($binder->id, $labels[0]->binder_id);
        $this->assertEquals($label_posts[0]['name'], $labels[0]->name);
    }
}
