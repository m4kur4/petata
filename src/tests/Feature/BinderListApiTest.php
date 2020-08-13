<?php

namespace Tests\Feature;

use App\User;
use App\Binder;
use App\BinderAuthority;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BinderListApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->binderListSelectService = app()->make(BinderListSelectServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * ユーザーがアクセス可能なバインダーだけを取得する。
     */
    public function Binders_Get_OnlyAccessible()
    {
        
    }


}
