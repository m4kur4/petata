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

class ImageSearchApiTest extends TestCase
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
     * 検索条件の指定をしない場合のテスト
     * 
     * - バインダーに登録されている全ての画像を取得すること
     * - 他バインダーの画像を取得しないこと
     */
    public function Image_Search_Success_ALL()
    {
        $this->actingAs($this->user);

        $MY_IMAGE_COUNT = 5;
        $OTHER_IMAGE_COUNT = 15;

        factory(Image::class, $MY_IMAGE_COUNT)->create([
            'binder_id' => $this->binder->id
        ]);
        
        // 他バインダーの画像
        factory(Image::class, $OTHER_IMAGE_COUNT)->create();

        // 検証
        $request = [
            'binder_id' => $this->binder->id,
        ];
        $response = $this->json('GET', route('api.binder.image.search', $request));

        $response->assertStatus(200);
        $response->assertJsonCount($MY_IMAGE_COUNT);
    }

    /**
     * @test
     * 
     * 画像名を条件に指定する場合のテスト
     * 
     * - 画像名が条件に前方一致する画像だけを取得すること
     */
    public function Image_Search_Success_ImageName()
    {
        $this->actingAs($this->user);

        $MY_IMAGE_COUNT = 5;
        $OTHER_IMAGE_COUNT = 3;
        $SEARCH_CONDITION_IMAGE_PREFIX = 'PETATA';

        for($i = 0; $i < $MY_IMAGE_COUNT; $i++) {
            factory(Image::class)->create([
                'binder_id' => $this->binder->id,
                'name' => $SEARCH_CONDITION_IMAGE_PREFIX . '\'s image' . $i
            ]);
        }

        for ($i = 0; $i < $OTHER_IMAGE_COUNT; $i++) {
            // 同じバインダーの検索対象外画像(部分・後方一致)
            factory(Image::class)->create([
                'binder_id' => $this->binder->id,
                'name' => $i . ' PETATA'
            ]);
        }
        // 検証
        $request = [
            'binder_id' => $this->binder->id,
            'image_name' => $SEARCH_CONDITION_IMAGE_PREFIX,
        ];
        $response = $this->json('GET', route('api.binder.image.search', $request));

        $response->assertStatus(200);
        $response->assertJsonCount($MY_IMAGE_COUNT);
    }

    /**
     * @test
     * 
     * ラベリングを条件に指定する場合のテスト
     * 
     * - 検索条件に指定されているラベリングの画像だけを取得すること
     */
    public function Image_Search_Success_Labeling()
    {
        $this->actingAs($this->user);

        $MY_IMAGE_COUNT = 5;
        $OTHER_IMAGE_COUNT = 3;

        $search_condition_label_ids = [];

        for($i = 0; $i < $MY_IMAGE_COUNT; $i++) {
            $image = factory(Image::class)->create([
                'binder_id' => $this->binder->id,
            ]);
            $label = factory(Label::class)->create([
                'binder_id' => $this->binder->id,
            ]);
            $labeling = factory(Labeling::class)->create([
                'image_id' => $image->id,
                'label_id' => $label->id,
            ]);
            if ($i == 0) {
                // 最初の1件だけ検索条件とする
                array_push($search_condition_label_ids, $label->id);
            }
        }

        for ($i = 0; $i < $OTHER_IMAGE_COUNT; $i++) {
            // 同じバインダーの検索対象外画像(ラベリングなし)
            $image = factory(Image::class)->create([
                'binder_id' => $this->binder->id,
            ]);
            $label = factory(Label::class)->create([
                'binder_id' => $this->binder->id,
            ]);
            $labeling = factory(Labeling::class)->create([
                'image_id' => $image->id,
                'label_id' => $label->id,
            ]);
        }

        // 検証
        $request = [
            'binder_id' => $this->binder->id,
            'label_ids' => $search_condition_label_ids,
        ];
        $response = $this->json('GET', route('api.binder.image.search', $request));

        $response->assertStatus(200);
        // ラベリングしたうちの1件だけを取得
        $response->assertJsonCount(1);
    }

}
