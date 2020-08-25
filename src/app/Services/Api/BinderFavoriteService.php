<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\BinderFavoriteRequest;

      /**
       * @inheritdoc
       */
interface BinderFavoriteService
{
    /**
     * コンストラクタ
     * 
     * @param BinderRepositoryInterface $binder_repository
     */
    public function __construct(
        BinderRepositoryInterface $binder_repository
      )
      {
          $this->binder_repository = $binder_repository;
      }
  
      /**
       * @inheritdoc
       */
      public function execute(BinderFavoriteRequest $request)
      {
        // TODO: 実装
      }
}