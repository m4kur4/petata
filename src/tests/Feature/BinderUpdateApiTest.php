<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\Label;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Log;

class BinderUpdateApiTest extends TestCase
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
     * バインダーを更新するテスト
     * 
     * - バインダーが更新されること
     * - リクエストした値がバインダーに設定されていること
     * - ラベルが更新されること
     * - リクエストした値がラベルに設定されていること
     * - ラベルの削除が反映されること
     */
    public function Binder_Update_Success()
    {
        $this->actingAs($this->user);

        $BINDER_NAME_AFTER = 'B_N_AFTER';
        $BINDER_DESCRIPTION_AFTER = 'B_D_AFTER';
        $LABEL_NAME_AFTER = 'L_N_AFTER';
        $LABEL_DESCRIPTION_AFTER = 'L_D_AFTER';

        $binder_before = factory(Binder::class)->create([
            'name' => 'B_N_BEFORE',
            'description' => 'B_D_BEFORE'
        ]);

        $label_change_target = factory(Label::class)->create([
            'binder_id' => $binder_before->id,
            'name' => 'L_N_BEFORE',
            'description' => 'L_D_BEFORE'
        ]);

        $label_delete_target = factory(Label::class)->create([
            'binder_id' => $binder_before->id,
        ]);

        $form_data = [
            'id' => $binder_before->id,
            'name' => $BINDER_NAME_AFTER,
            'description' => $BINDER_DESCRIPTION_AFTER,
            'labels' => [
                [
                    'id' => $label_change_target->id, 
                    'name' => $LABEL_NAME_AFTER, 
                    'description' => $LABEL_DESCRIPTION_AFTER
                ],
            ],
        ];

        // 検証
        $response = $this->json('POST', route('api.binder.save'), $form_data);
        $response->assertStatus(200);

        // - バインダーが更新されること
        // - リクエストした値がバインダーに設定されていること
        $binder_after = Binder::find($binder_before->id);
        $this->assertEquals($BINDER_NAME_AFTER, $binder_after->name);
        $this->assertEquals($BINDER_DESCRIPTION_AFTER, $binder_after->description);

        // - ラベルが更新されること
        // - リクエストした値がラベルに設定されていること
        $label_after = Label::find($label_change_target->id);
        $this->assertEquals($LABEL_NAME_AFTER, $label_after->name);
        $this->assertEquals($LABEL_DESCRIPTION_AFTER, $label_after->description);

        // - ラベルの削除が反映されること
        $this->assertEquals(false, (function() use($label_delete_target) {
            return Label::query()
                ->where('id', $label_delete_target->id)
                ->exists();
        })());
    }
}
