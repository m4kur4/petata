<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\BinderFavorite;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderSearchApiTest extends TestCase
{
    use RefreshDatabase;

    const OWN_BINDER_COUNT = 3; // 自分が作成したバインダーの数
    const OTHER_BINDER_COUNT = 4; // 他人が作成したバインダーの数
    const UNACCESSIBLE_BINDER_COUNT = 10; // 無関係なバインダーの数

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * 検索条件を指定しない場合のテスト
     * 
     * - ログインユーザーがアクセス可能な全てのバインダーを取得すること
     */
    public function Binder_Search_Success_ALL()
    {
        $this->actingAs($this->user);
        $this->createTestData();

        // 検証
        $request = [];
        $response = $this->json('GET', route('api.binder.search', $request));
        $response->assertStatus(200);

        //- ログインユーザーがアクセス可能な全てのバインダーを取得すること
        $accessible_count = self::OWN_BINDER_COUNT + self::OTHER_BINDER_COUNT;
        $response->assertJsonCount($accessible_count);
    }

    /**
     * @test
     *
     * 自分が作成したバインダーを検索するテスト
     * 
     * - ログインユーザーが作成したバインダーだけを取得すること
     */
    public function Binder_Search_Success_Own()
    {
        $this->actingAs($this->user);
        $this->createTestData();

        // 検証
        $request = ['is_own' => true];
        $response = $this->json('GET', route('api.binder.search', $request));
        $response->assertStatus(200);

        // - ログインユーザーが作成したバインダーだけを取得すること
        $response->assertJsonCount(self::OWN_BINDER_COUNT);
    }

    /**
     * @test
     *
     * 他人が作成したバインダーを検索するテスト
     * お気に入り登録しているバインダーを検索するテスト
     * バインダー名が前方一致するバインダーを検索するテスト
     * 
     * - ログインユーザーが作成したバインダーだけを取得すること
     */
    public function Binder_Search_Success_Other()
    {
        $this->actingAs($this->user);
        $this->createTestData();

        // 検証
        $request = ['is_other' => true];
        $response = $this->json('GET', route('api.binder.search', $request));
        $response->assertStatus(200);

        // - 他人が作成したバインダーだけを取得すること
        $response->assertJsonCount(self::OTHER_BINDER_COUNT);
    }

    /**
     * @test
     *
     * お気に入り登録しているバインダーを検索するテスト
     * バインダー名が前方一致するバインダーを検索するテスト
     * 
     * - ログインユーザーが作成したバインダーだけを取得すること
     */
    public function Binder_Search_Success_Favorite()
    {
        $this->actingAs($this->user);
        $this->createTestData();

        // 検証
        $request = ['is_favorite' => true];
        $response = $this->json('GET', route('api.binder.search', $request));
        $response->assertStatus(200);

        // - ログインユーザーがお気に入り登録したバインダーだけを取得すること
        // NOTE: 自分・他人のバインダーを一つずつお気に入り登録している
        $FAVORITE_COUNT = 2; 
        $response->assertJsonCount($FAVORITE_COUNT);
    }

    /**
     * @test
     *
     * バインダー名が前方一致するバインダーを検索するテスト
     * 
     * - ログインユーザーが作成したバインダーだけを取得すること
     */
    public function Binder_Search_Success_Name()
    {
        $this->actingAs($this->user);
        $this->createTestData();

        // 検証
        $request = ['binder_name' => '12'];
        $response = $this->json('GET', route('api.binder.search', $request));
        $response->assertStatus(200);

        // - 名前が検索条件に前方一致するバインダーだけを取得すること
        // NOTE: 自分・他人のバインダーでバインダー名の先頭を"12"にしている
        $MATCH_COUNT = 2; 
        $response->assertJsonCount($MATCH_COUNT);
    }

    /**
     * テストデータを作成します。
     */
    private function createTestData()
    {
        $this->actingAs($this->user);

        $own_binders = factory(Binder::class, self::OWN_BINDER_COUNT)->create([
            'create_user_id' => $this->user->id
        ]);

        $other_binders = factory(Binder::class, self::OTHER_BINDER_COUNT)->create();

        $unaccessible_binders = factory(Binder::class, self::UNACCESSIBLE_BINDER_COUNT)->create();

        // 権限付与 - 自分のバインダー
        foreach($own_binders as $index => $binder) {

            if ($index == 0) {
                // 最初の要素だけ名前を変更する
                $binder->name = '12345';
                $binder->save();
                // 最初の要素だけお気に入り登録する
                factory(BinderFavorite::class)->create([
                    'user_id' => $this->user->id,
                    'binder_id' => $binder->id
                ]);
            }
            $param = [
                'user_id' => $this->user->id,
                'binder_id' => $binder->id
            ];
            factory(BinderAuthority::class)->create($param);
        }
        // 権限付与 - 他人のバインダー
        foreach($other_binders as $index => $binder) {

            if ($index == 0) {
                // 最初の要素だけ名前を変更する
                $binder->name = '12';
                $binder->save();
                // 最初の要素だけお気に入り登録する
                factory(BinderFavorite::class)->create([
                    'user_id' => $this->user->id,
                    'binder_id' => $binder->id
                ]);
            }

            $param = [
                'user_id' => $this->user->id,
                'binder_id' => $binder->id
            ];
            factory(BinderAuthority::class)->create($param);
        }
    }

}
