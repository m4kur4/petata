<?php

namespace Tests\Feature;

use App\Models\Binder;
use App\Models\Image;
use App\Models\Label;
use App\Models\Labeling;
use App\Models\User;
use App\Http\Requests\ImageAddRequest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Log;

class ImageDeleteApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->binder = factory(Binder::class)->create();
    }

    /**
     * @test
     * 
     * テストを停止中に警告が表示されないようにする
     */
    public function Avoid_Worning()
    {
        $this->assertEquals(1,1);
    }

    /**
     * TODO: 画像削除時の並び順振りなおしに使うユーザー定義変数がSQLite未対応のため、試験を停止中
     * 
     * 画像を削除するテスト
     * 
     * - 指定した画像だけが削除されていること
     * - 画像に関連するラベリングが削除されていること
     * - 削除されていない画像のリストが返却されること
     */
    public function Image_Delete_Success()
    {
        $this->actingAs($this->user);

        $IMAGE_COUNT = 5;
        $REMAIN_IMAGE_COUNT = 3;
        $DELETE_IMAGE_COUNT = $IMAGE_COUNT - $REMAIN_IMAGE_COUNT;

        $images = factory(Image::class, $IMAGE_COUNT)->create([
            'binder_id' => $this->binder->id
        ]);

        $label = factory(Label::class)->create([
            'binder_id' => $this->binder->id
        ]);

        foreach($images as $image) {
            factory(Labeling::class)->create([
                'label_id' => $label->id,
                'image_id' => $image->id
            ]);
        }

        // 削除対象の画像ID
        $delete_target_image_ids = [];
        for($i = 0; $i < $DELETE_IMAGE_COUNT; $i++) {
            array_push($delete_target_image_ids, $images[$i]->id);
        }

        // 検証
        $request = [
            'image_ids' => $delete_target_image_ids,
            'binder_id' => $this->binder->id,
            'image_name' => null,
            'label_ids' => [],
        ];
        $response = $this->json('POST', route('api.binder.image.delete', $request));

        $response->assertStatus(200);

        // - 指定した画像だけが削除されていること
        $this->assertEquals($REMAIN_IMAGE_COUNT, (function() use($image){
            return Image::all()->count();
        })());
        $this->assertEquals(false, (function() use($delete_target_image_ids){
            return Image::whereIn('image_id', $delete_target_image_ids)->exists();
        })());

        // - 画像に関連するラベリングが削除されていること
        $this->assertEquals($REMAIN_IMAGE_COUNT, (function() use($label){
            return Labeling::where('label_id', $label->id)->count();
        })());

        // - 削除されていない画像のリストが返却されること
        $response->assertJsonCount($REMAIN_IMAGE_COUNT);
    }
}
