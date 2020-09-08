<?php

namespace App\Traits;

use DB;
use Log;

/**
 * 生SQL生成をサポートするトレイトです。
 */
trait RawSqlBuildTrait
{

    /**
     * 並び順を【前方】に更新するSQL文を返却します。
     * 
     * @param string $table_name テーブル物理名
     * @return string
     */
    protected function getSortUpdateQueryForward($table_name)
    {
        // 関連するレコードを後ろへずらす
        $query_base = "
            UPDATE 
              %s
            SET 
              sort = sort + 1
            WHERE 
              binder_id = ?
            AND
              sort >= ?
            AND
              sort < ?;
        ";
        $query = sprintf($query_base, $table_name);

        return $query;
    }

    /**
     * 並び順を【後方】に更新するSQL文を返却します。
     * 
     * @param string $table_name テーブル物理名
     * @return string
     */
    protected function getSortUpdateQueryBackward($table_name)
    {
        // 関連するレコードを前へずらす
        $query_base = "
            UPDATE 
                %s
            SET 
              sort = sort - 1
            WHERE 
              binder_id = ?
            AND
              sort > ?
            AND
              sort <= ?;
        ";
        $query = sprintf($query_base, $table_name);

        return $query;
    }
  
    /**
     * 全ての並び順を振りなおすSQL文を返却します。
     * 返却前に、ユーザー定義変数をSQLセッションへ設定します。
     * 
     * @param string $table_name テーブル物理名
     * @return string
     */
    protected function getSortResetQuery($table_name)
    {
        // ユーザー定義変数を設定
        $query_prepare = '
            SET @i := 0;
        ';
        DB::statement($query_prepare);

        // SQL文の生成
        $query_base = '
            UPDATE 
              %s
            SET 
              sort = (@i := @i + 1)
            WHERE 
              binder_id = ?
            ORDER BY 
              sort;
        ';
        $query = sprintf($query_base, $table_name);

        return $query;
    }


}