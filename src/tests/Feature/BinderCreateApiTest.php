<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BinderCreateApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // インスタンス生成
        $this->binderCreateService = app()->make(BinderCreateServiceInterface::class);
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     *
     * 正しいリクエストを送信し、バインダー作成に成功する。
     */
    public function Binder_Create_Success()
    {
        $form_data = [
            'name' => 'バインダー名',
            'description' => 'バインダーの説明',
            'label_names[0]' => 'ラベル名_0',
            'label_descriptions[0]' => 'ラベルの説明_0',
            'label_names[1]' => 'ラベル名_1',
            'label_descriptions[1]' => 'ラベルの説明_1',
            'label_names[2]' => 'ラベル名_2',
            'label_descriptions[2]' => 'ラベルの説明_2',
        ];
    }
}
