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

class ImageRenameApiTest extends TestCase
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
     * 画像をリネームするテスト
     * 
     * - 指定した画像が期待通りリネームされていること
     */
    public function Image_Rename_Success()
    {
        $INIT_NAME = 'first';
        $EDITED_NAME = 'second';

        $dummy_image = factory(Image::class)->create([
            'name' => $INIT_NAME
        ]);

        $request = [
            'binder_id' => $this->binder->id,
            'id' => $dummy_image->id,
            'name' => $EDITED_NAME
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.binder.image.rename'), $request);

        $image = Image::first();
        
        $response->assertStatus(200);
        $this->assertEquals($image->name, $EDITED_NAME);
    }
}
