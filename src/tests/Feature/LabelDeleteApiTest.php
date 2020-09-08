<?php

namespace Tests\Feature;

use App\Models\Binder;
use App\Models\User;
use App\Models\Label;
use App\Models\Image;
use App\Models\Labeling;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Log;


class LabelDeleteApiTest extends TestCase
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
     * テストを停止中に警告が表示されないようにする
     */
    public function Avoid_Worning()
    {
        $this->assertEquals(1,1);
    }

    /**
     * TODO: ラベル削除時の並び順振りなおしに使うユーザー定義変数がSQLite未対応のため、試験を停止中
     * 
     * ラベルを削除するテスト
     * 
     * - 指定したラベルだけが削除されていること
     * - ラベルに関連するラベリングが削除されていること
     */
    public function Label_Delete_Success()
    {
        // 削除後に残るラベルの数
        $REMAIN_LABEL_COUNT = 5;

        $binder = factory(Binder::class)->create();
        $label = factory(Label::class)->create([
            'binder_id' => $binder->id
        ]);
        $image = factory(Image::class)->create([
            'binder_id' => $binder->id
        ]);
        $labeling = factory(Labeling::class)->create([
            'label_id' => $label->id,
            'image_id' => $image->id
        ]);

        $other_labels = factory(Label::class, $REMAIN_LABEL_COUNT)->create([
            'binder_id' => $binder->id
        ]);

        $formData = [
            'label_id' => $label->id,
            'binder_id' => $binder->id,
        ];

        // 検証
        $response = $this->actingAs($this->user)
            ->json('POST', route('api.binder.label.delete'), $formData);
        
        $response->assertStatus(200);
        
        // - 削除後の件数
        $response->assertJsonCount($REMAIN_LABEL_COUNT);
        
        // - 削除対象の存在
        $this->assertEquals(false, (function() use($label) {
            return Label::where('id', $label->id)->exists();
        })());

        // - 削除対象に紐づくラベリングの存在
        $this->assertEquals(false, (function() use($label) {
            return Labeling::where('label_id', $label->id)->exists();
        })());
    }
}
