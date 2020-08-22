<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderCreateApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->binderCreateService = app()->make(BinderCreateServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * 正しいリクエストを送信し、バインダー作成に成功する。
     */
    public function Binder_Create_Success()
    {
        $this->actingAs($this->user);

        $form_data = [
            'name' => 'バインダー名',
            'description' => 'バインダーの説明',
            'labels' => [
                ['name' => 'ラベル_1', 'description' => '説明_1'],
                ['name' => 'ラベル_2'],
                ['name' => 'ラベル_3', 'description' => '説明_3'],
            ],
        ];
        $response = $this->json('POST', route('api.binder.create'), $form_data);

        // 検証
        $binder = Binder::first();
        $labels = $binder->labels()->orderBy('id')->get();

        // -バインダー情報の確認
        $this->assertEquals($binder->name, $form_data['binder_name']);
 
        // - 認可情報の確認
        $binder_authority_first = BinderAuthority::first();
        $this->assertEquals($binder_authority_first->level, config('_const.BINDER_AUTHORITY.LEVEL.OWNER'));

        // - ラベル情報の確認
        $this->assertEquals($labels->count(), 3);
        $this->assertEquals($labels->first()->name, $form_data['label_names'][1]);
    }
}
