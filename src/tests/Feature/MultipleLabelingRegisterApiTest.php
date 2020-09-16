<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Label;
use App\Models\Image;
use App\Models\Binder;
use App\Models\Labeling;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Log;


class MultipleLabelingRegisterApiTest extends TestCase
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
     * 複数のラベリングを同時に登録するテスト
     * 
     * - 選択していない画像のラベリングが解除されていること
     * - 選択した画像のラベリングが登録されていること
     */
    public function Labeling_Register_Multi_Success()
    {
        $response = $this->actingAs($this->user);

        $binder = factory(Binder::class)->create();
        $labels = factory(Label::class, 5)->create([
            'binder_id' => $binder->id
        ]);
        $images = factory(Image::class, 5)->create([
            'binder_id' => $binder->id
        ]);

        $image_1 = $images[0];
        $image_2 = $images[1];
        $unselect_image = $images[2];

        $label_1 = $labels[0];
        $label_2 = $labels[1];
        $label_3 = $labels[2];

        $post_image_ids = [
            $image_1->id,
            $image_2->id,
        ];

        $post_label_ids = [
            $label_1->id,
            $label_2->id,
            $label_3->id,
        ];

        $post_data = [
            'image_ids' => $post_image_ids,
            'label_ids' => $post_label_ids
        ];

        // APIを呼び出す前に削除が期待されるラベリングを作成する
        factory(Labeling::class)->create([
            'label_id' => $label_1->id,
            'image_id' => $unselect_image->id,
        ]);

        // 検証
        $response = $this->json('POST', route('api.binder.image.labeling.multiple'), $post_data);

        $test_count = Labeling::all()->count();

        $response->assertStatus(201);

        // - 選択していない画像のラベリングが解除されていること
        $this->assertEquals(false, (function() use($unselect_image){

            return Labeling::query()
                ->where('image_id', $unselect_image->id)
                ->exists();
        })());

        // - 選択した画像のラベリングが登録されていること
        $COMBINATION_COUNT = 6;
        $this->assertEquals($COMBINATION_COUNT, (function() {
            return Labeling::all()->count();
        })());
    }
}
