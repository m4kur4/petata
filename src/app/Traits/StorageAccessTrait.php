<?php

namespace App\Traits;

use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageRemoveRequest;
use App\Http\Requests\ImageRenameRequest;

use Log;
use Storage;

/**
 * ストレージに対するファイル操作トレイト
 */
trait StorageAccessTrait
{

  /**
   * 単一ファイルをストレージへアップロードします。
   */
  protected function  upload()
  {}
  
  /**
   * 複数ファイルをストレージへ一括アップロードします。
   */
  protected function uploadMany()
  {}

  /**
   * 単一ファイルをストレージからダウンロードします。
   */
  protected function download()
  {}

  /**
   * 複数ファイルをストレージから一括ダウンロードします。
   */
  protected function download()
  {}

  /**
   * 単一ファイルをストレージから削除します。
   */
  protected function delete()
  {}

  /**
   * 複数ファイルをストレージから一括削除します。
   */
  protected function deleteMany()
  {}

  /**
   * 単一ファイルをストレージ上でリネームします。
   */
  protected function rename()
  {}

  /**
   * 複数ファイルをストレージで一括リネームします。
   */
  protected function renameMany()
  {}
}