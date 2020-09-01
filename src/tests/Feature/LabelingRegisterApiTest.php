<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Label;
use App\Models\Image;
use App\Models\Labeling;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Log;


class LabelingRegisterApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     * 
     * 正しいリクエストを送信し、ラベリングの登録に成功する。
     */
    public function Labeling_Register_Success()
    {
        $label = factory(Label::class)->create();
        $image = factory(Image::class)->create();

        $formData = [
            'label_id' => $label->id,
            'image_id' => $image->id,
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.binder.image.labeling'), $formData);
        $labeling = Labeling::first();
        
        // - ステータスコードが期待通り返却されていること
        $response->assertStatus(201);
        
        // - パラメタが期待通り設定されていること
        $this->assertEquals($label->id, $labeling->label_id);
        $this->assertEquals($image->id, $labeling->image_id);
    }
}
