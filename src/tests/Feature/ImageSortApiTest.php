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

class ImageSortApiTest extends TestCase
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
     * 画像の並び順を更新するテスト(前方)
     * 
     * - 前方への移動が期待通り行われること
     * - 一番前への移動が期待通り行われること
     * - 並び順が重複しないように更新されていること
     * 
     */
    public function Image_SortUpdateForward_Success()
    {
        $IMAGE_COUNT = 5;
        $TARGET_IMAGE_INDEX = 0;
        $SORT_AFTER = 1;

        for ($i = 0; $i < $IMAGE_COUNT; $i++) {
            factory(Image::class)->create([
                'binder_id' => $this->binder->id,
                'sort' => $i + 1
            ]);
        }

        $images = Image::query()
            ->orderBy('sort')
            ->get();

        $sort_target_image = $images->get($TARGET_IMAGE_INDEX);

        $request = [
            'binder_id' => $this->binder->id,
            'target_id' => $sort_target_image->id,
            'sort_after' => $SORT_AFTER
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.binder.image.sort'), $request);
        $response->assertStatus(200);

        // - 更新後の対象画像が期待どおりの並び順であること
        $sorted_image = Image::find($sort_target_image->id);
        $this->assertEquals($SORT_AFTER, $sorted_image->sort);

        // - 並び順が重複しないように更新されていること
        $EXPECTED_SORTS = [1, 2, 3, 4, 5];
        $this->assertEquals($EXPECTED_SORTS, (function() {
            $sorts = Image::select('sort')
                ->orderBy('sort')
                ->get()
                ->pluck('sort')
                ->toArray();

            return $sorts;
        })());
    }

    /**
     * @test
     * 
     * 画像の並び順を更新するテスト(後方)
     * 
     * - 後方への移動が期待通り行われること
     * - 一番後ろへの移動が期待通り行われること
     * - 並び順が重複しないように更新されていること
     */
    public function Image_SortUpdateBackward_Success()
    {
        $IMAGE_COUNT = 5;
        $TARGET_IMAGE_INDEX = $IMAGE_COUNT - 1;
        $SORT_AFTER = $IMAGE_COUNT;

        for ($i = 0; $i < $IMAGE_COUNT; $i++) {
            factory(Image::class)->create([
                'binder_id' => $this->binder->id,
                'sort' => $i + 1
            ]);
        }

        $images = Image::query()
            ->orderBy('sort')
            ->get();

        $sort_target_image = $images->get($TARGET_IMAGE_INDEX);

        $request = [
            'binder_id' => $this->binder->id,
            'target_id' => $sort_target_image->id,
            'sort_after' => $SORT_AFTER
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.binder.image.sort'), $request);
        $response->assertStatus(200);

        // - 更新後の対象画像が期待どおりの並び順であること
        $sorted_image = Image::find($sort_target_image->id);
        $this->assertEquals($SORT_AFTER, $sorted_image->sort);

        // - 並び順が重複しないように更新されていること
        $EXPECTED_SORTS = [1, 2, 3, 4, 5];
        $this->assertEquals($EXPECTED_SORTS, (function() {
            $sorts = Image::select('sort')
                ->orderBy('sort')
                ->get()
                ->pluck('sort')
                ->toArray();

            return $sorts;
        })());
    }
}
