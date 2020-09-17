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

class ImageDownloadApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->binder = factory(Binder::class)->create();
    }

    /**
     * FIXME: ダミーのS3を対象としたZipStreamの使い方が不明のため試験停止
     * @test
     * 画像をダウンロードするテスト
     */
    public function Image_Download_Success()
    {
        Storage::fake('s3');
        $BINDER_ID = 1;

        $form_data = [
            'images' => [UploadedFile::fake()->image('test.jpg')],
            'binder_id' => $BINDER_ID
        ];

        // 画像をアップロードする
        $this->actingAs($this->user)
            ->json('POST', route('api.binder.image.add'), $form_data);
        $image = Image::first();

        $request = [
            'image_ids' => [$image->id]
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('GET', route('api.binder.image.download', $request));
        
        $response->assertStatus(200);
    }
}
