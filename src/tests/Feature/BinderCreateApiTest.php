<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Services\Api\Interfaces\BinderSaveServiceInterface;

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
        $this->binderCreateService = app()->make(BinderSaveServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * バインダーを新規作成するテスト
     * 
     * - バインダーが作成されること
     * - リクエストした値がバインダーに設定されていること
     * - 作成したバインダーに対する期待通りの認可情報が設定されていること
     * - リクエストしたラベルがバインダーに紐づいて作成されていること
     */
    public function Binder_Create_Success()
    {
        $this->actingAs($this->user);
        // 新規作成のレコードID設定値
        $NEW_RECORD_ID = 0;

        $form_data = [
            'name' => 'バインダー名',
            'description' => 'バインダーの説明',
            'labels' => [
                ['id' => $NEW_RECORD_ID, 'name' => 'ラベル_1', 'description' => '説明_1'],
                ['id' => $NEW_RECORD_ID, 'name' => 'ラベル_2', 'description' => ''],
                ['id' => $NEW_RECORD_ID, 'name' => 'ラベル_3', 'description' => '説明_3'],
            ],
        ];
        $response = $this->json('POST', route('api.binder.create'), $form_data);

        // 検証
        $binder = Binder::first();
        $labels = $binder->labels()->orderBy('id')->get();

        // - バインダー情報の確認
        $this->assertEquals($binder->name, $form_data['name']);
        $this->assertEquals($binder->description, $form_data['description']);
        
        // - 認可情報の確認
        $binder_authority_first = BinderAuthority::first();
        $this->assertEquals($binder_authority_first->level, config('_const.BINDER_AUTHORITY.LEVEL.OWNER'));

        // - ラベル情報の確認
        $this->assertEquals($labels->count(), 3);
        $this->assertEquals($labels->first()->name, $form_data['labels'][0]['name']);
    }
}
