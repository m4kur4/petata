<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderFavorite;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderfavoriteApiTest extends TestCase
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
     * バインダーをお気に入り登録するテスト
     * 
     * - 指定したユーザーとバインダーが紐づけられること
     */
    public function Binder_FavoriteAdd_Success()
    {
        $this->actingAs($this->user);

        $binder = factory(Binder::class)->create();

        $form_data = [
            'binder_id' => $binder->id,
        ];

        // 検証
        $response = $this->json('POST', route('api.binder.favorite'), $form_data);

        $response->assertStatus(200);

        // - 指定したユーザーとバインダーが紐づけられること
        $binderFavorite = BinderFavorite::first();
        $this->assertEquals($binderFavorite->binder_id, $binder->id);
        $this->assertEquals($binderFavorite->user_id, $this->user->id);
    }

    /**
     * @test
     *
     * バインダーをお気に入り解除するテスト
     * 
     * - 指定したユーザーとバインダーが切り離されること
     */
    public function Binder_FavoriteRemove_Success()
    {
        $this->actingAs($this->user);

        $binder = factory(Binder::class)->create();
        factory(BinderFavorite::class)->create([
            'binder_id' => $binder->id,
            'user_id' => $this->user->id
        ]);

        $form_data = [
            'binder_id' => $binder->id,
        ];

        // 検証
        $response = $this->json('POST', route('api.binder.favorite'), $form_data);

        $response->assertStatus(200);
        
        // - 指定したユーザーとバインダーが紐づけられること
        $binderFavorite = BinderFavorite::first();
        $user = $this->user;
        $this->assertEquals(false, (function() use($binder, $user) {
                return BinderFavorite::query()
                    ->where('binder_id', $binder->id)
                    ->where('user_id', $this->user->id)
                    ->exists();
        })());
    }
}
