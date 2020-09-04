<?php

use Illuminate\Database\Seeder;

class BindersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('binders')->insert([
            'create_user_id' => 1,
            'name' => 'ぺた太のアートワーク',
        ]);

        DB::table('binder_authorities')->insert([
            'user_id' => 1,
            'binder_id' => 1,
            'level' => config('_const.BINDER_AUTHORITY.LEVEL.OWNER'),
        ]);
    }
}
