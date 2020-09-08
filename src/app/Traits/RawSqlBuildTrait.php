<?php

namespace App\Traits;

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
    private function getSortUpdateQueryForward($table_name)
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
    private function getSortUpdateQueryBackward($table_name)
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
  

}