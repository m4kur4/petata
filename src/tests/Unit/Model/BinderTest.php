<?php

namespace Tests\Feature\Unit\Repository;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderFavorite;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }
    
    /**
     * @test
     * 
     * バインダーが指定したユーザーのお気に入りかどうか
     */
    public function isOwn()
    {
        $me = factory(User::class)->create();
        $other = factory(User::class)->create();

        $this->actingAs($me);

        $others_binder = factory(Binder::class)
            ->create([
                'create_user_id' => $other->id,
                'name' => 'test'
            ]);
            
        $my_binder = factory(Binder::class)
            ->create([
                'create_user_id' => $me->id,
                'name' => 'test'
            ]);

        $this->assertEquals($others_binder->isOwn, false);
        $this->assertEquals($my_binder->isOwn, true);
    }

    /**
     * @test
     * 
     * バインダーが指定したユーザーのお気に入りかどうか
     */
    public function isFavorite()
    {
        $me = factory(User::class)->create();
        $other = factory(User::class)->create();

        $this->actingAs($me);

        $others_favorite_binder = factory(Binder::class)->create();
        $my_favorite_binder = factory(Binder::class)->create();

        $other_bookmark = factory(BinderFavorite::class)
            ->create([
                'binder_id' => $others_favorite_binder->id,
                'user_id' => $other->id
            ]);
        $other_bookmark = factory(BinderFavorite::class)
            ->create([
                'binder_id' => $my_favorite_binder->id,
                'user_id' => $me->id
            ]);

        $this->assertEquals($others_favorite_binder->isFavorite, false);
        $this->assertEquals($my_favorite_binder->isFavorite, true);
    }

    
}