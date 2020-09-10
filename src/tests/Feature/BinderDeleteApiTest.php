<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\BinderFavorite;
use App\Models\Image;
use App\Models\Label;
use App\Models\Labeling;
use App\Services\Api\Interfaces\BinderSaveServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use File;
use FileManageHelper;
use Log;
use Storage;

class BinderDeleteApiTest extends TestCase
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
     * バインダーを削除するテスト
     * 
     * - バインダーが削除されること
     * - 削除したバインダーに紐づく画像が削除されること(データ、ファイル)
     * - 削除したバインダーに紐づくラベルが削除されること
     * - 削除したバインダーに紐づくお気に入り情報が削除されること
     */
    public function Binder_Delete_Success()
    {
        $this->actingAs($this->user);
        // バインダー作成
        $binder = factory(Binder::class)->create();

        // 権限を付与
        $binder_authority = factory(BinderAuthority::class)->create([
            'user_id' => $this->user->id,
            'binder_id' => $binder->id
        ]);

        // ラベル追加
        $label = factory(Label::class)->create([
            'binder_id' => $binder->id
        ]);

        // 画像追加(ファイルもアップロードするためAPI経由でテストデータを作成する)
        $form_data_for_add_image = [
            'image' => UploadedFile::fake()->image('test.jpg'),
            'binder_id' => $binder->id
        ];
        $this->json('POST', route('api.binder.image.add'), $form_data_for_add_image);
        $image = Image::first();

        // ラベリング追加
        $labeling = factory(Labeling::class)->create([
            'image_id' => $image->id,
            'label_id' => $label->id,
        ]);

        // お気に入り追加
        $binder_favorite = factory(BinderFavorite::class)->create([
            'binder_id' => $binder->id,
            'user_id' => $this->user->id
        ]);

        // 検証
        $form_data = [
            'binder_id' => $binder->id
        ];
        $response = $this->json('POST', route('api.binder.delete'), $form_data);
        $response->assertStatus(200);

        // - バインダーが削除されること
        $this->assertEquals(false, (function() use($binder) {
            return Binder::query()
                ->where('id', $binder->id)
                ->exists();
        })());

        // - 削除したバインダーに紐づく画像が削除されること(データ、ファイル)
        //   - データ
        $this->assertEquals(false, (function() use($image) {
            return Image::query()
                ->where('id', $image->id)
                ->exists();
        })());
        //   - オリジナル画像
        $this->assertEquals(false, (function() use($image) {
            // TODO: S3を使う
            //return Storage::disk('s3')->(FileManageHelper::getBinderImageRelativePath($image));
            return Storage::disk('public')->exists(FileManageHelper::getBinderImageRelativePath($image));
        })());
        //   - png画像
        $this->assertEquals(false, (function() use($image) {
            // TODO: S3を使う
            //return Storage::disk('s3')->(FileManageHelper::getBinderImageRelativePath($image, 'png'));
            return Storage::disk('public')->exists(FileManageHelper::getBinderImageRelativePath($image, 'png'));
        })());

        // - 削除したバインダーに紐づくラベルとラベリングが削除されること
        //    - ラベル
        $this->assertEquals(false, (function() use($label) {
            return Label::query()
                ->where('id', $label->id)
                ->exists();
        })());
        //    - ラベリング
        $this->assertEquals(false, (function() use($labeling) {
            return Labeling::query()
                ->where('id', $labeling->id)
                ->exists();
        })());

        // - 削除したバインダーに紐づくお気に入り情報が削除されること
        $this->assertEquals(false, (function() use($binder_favorite) {
            return BinderFavorite::query()
                ->where('id', $binder_favorite->id)
                ->exists();
        })());

        // - 削除したバインダーに紐づく操作権限が削除されること
        $this->assertEquals(false, (function() use($binder_authority) {
            return BinderAuthority::query()
                ->where('id', $binder_authority->id)
                ->exists();
        })());
    }
}
