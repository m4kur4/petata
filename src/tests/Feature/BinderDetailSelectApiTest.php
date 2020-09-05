<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\Image;
use App\Models\Label;
use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderDetailSelectApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->binder_detail_select_service = app()->make(BinderDetailSelectServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     * 
     * ログインユーザーが自身のバインダー情報取得に成功する
     */
    public function Binder_Get_Success()
    {
        $this->actingAs($this->user);

        // バインダー作成
        $binder = factory(Binder::class)->create();

        // 権限を付与
        factory(BinderAuthority::class)->create([
            'user_id' => $this->user->id,
            'binder_id' => $binder->id
        ]);

        // ラベル追加
        factory(Label::class)->create([
            'binder_id' => $binder->id
        ]);

        // 画像追加
        factory(Image::class)->create([
            'binder_id' => $binder->id,
            'extension' => 'jpg'
        ]);

        // 検証
        $response = $this->json('GET', route('api.binder.detail', ['binder_id' => $binder->id]));

        // - 期待通りのステータスコードが返却されていること
        $response->assertStatus(200);

        // - 期待通りのデータが取得できていること
        $response->assertJsonFragment([
                'id' => $binder->id,
                'name' => $binder->name,
                'description' => $binder->description,
                'count_user' => $binder->binderAuthorities->count(),
                'count_image' => $binder->images->count(),
                'count_label' => $binder->labels->count(),
                'count_favorite' => $binder->binderFavorites->count(),
                'labels' => $binder->labels
                    ->sortByDesc('id')
                    ->map(function($label) {
                        return [
                            'id' => $label->id,
                            'binder_id' => $label->binder_id,
                            'name' => $label->name,
                            'description' => $label->description
                        ];
                    })
                    ->all(),
                'images' => $binder->images
                    ->sortByDesc('id')
                    ->map(function($image) {
                        return [
                            'id' => $image->id,
                            'binder_id' => $image->binder_id,
                            'upload_user_id' => $image->upload_user_id,
                            'name' => $image->name,
                            'path' => $image->path,
                            'visible' => $image->visible,
                            'storage_file_path' => $image->storageFilePath,
                            'labeling_label_ids' => $image->labeling_label_ids,
                        ];
                    })
                    ->all(),
            ]);
    }
}
