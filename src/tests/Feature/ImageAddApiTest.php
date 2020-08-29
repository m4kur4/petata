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
     * 正しいリクエストを送信し、画像の追加に成功する。
     */
    public function Image_Create_Success()
    {
        Storage::fake('s3');

        $formData = [
            'image' => UploadedFile::fake()->image('test.jpg'),
            'binder_id' => 1
        ];

        $response = $this->actingAs($this->user)
            ->json('POST', route('api.image.add'), $formData);

        $response->assertStatus(201);
    }
}
