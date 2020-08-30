<?php

namespace Tests\Feature;

use App\Models\Binder;
use App\Models\Image;
use App\Models\User;
use App\Http\Requests\ImageAddRequest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use FileManageHelper;
use Log;
use Storage;

class ImageAddApiTest extends TestCase
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
     * // TODO: 開発中はS3を使わないため、試験を停止中
     * 
     * 正しいリクエストを送信し、画像の追加に成功する。
     */
    public function Image_Create_Success()
    {
        Storage::fake('s3');
        $BINDER_ID = 1;

        $formData = [
            'image' => UploadedFile::fake()->image('test.jpg'),
            'binder_id' => $BINDER_ID
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.image.add'), $formData);
        $image = Image::first();
        
        // - ステータスコードが期待通り返却されていること
        $response->assertStatus(201);
        
        // - ファイルパスが期待通り設定されていること
        $this->assertRegExp('/^[0-9a-zA-Z-_]{24}$/', $image->path);
        
        // - ストレージに期待通りファイルがアップロードされていること
        //   NOTE: アップロード先 ⇒ binder/<binder_id>/<path>
        // Log::debug(Storage::cloud()->allFiles());
        Storage::cloud()->assertExists(FileManageHelper::getBinderImagePath($image));
    }
}
