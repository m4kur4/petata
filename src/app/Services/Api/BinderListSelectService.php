<?php

namespace App\Services\Api;

use App\Models\User;
use App\Models\Binder;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Traits\BinderTrait;
use Log;

/**
 * @inheritdoc
 */
class BinderListSelectService implements BinderListSelectServiceInterface
{
    /**
     * バインダー処理トレイト
     *  - getBinderThumbnailUrl($binder)
     */
    use BinderTrait;

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
    public function execute(string $user_id)
    {
        $binders = $this->binder_repository->selectByAuthorizedUserId($user_id);
        $response = $binders->map(function($binder) {
            // フロントで使用する情報
            $visible = [
                'id' => $binder->id,
                'name' => $binder->name,
                'description' => $binder->description,
                'count_user' => $binder->binderAuthorities->count(),
                'count_image' => $binder->images->count(), 
                'count_label' => $binder->labels->count(),
                'count_favorite' => $binder->binderfavorites->count(),
                'is_own' => $binder->isOwn,
                'is_favorite' => $binder->isFavorite,
                'labels' => $binder->labels
                    ->sortBy('sort')
                    ->values()
                    ->all(),
                'thumbnail_url' => $this->getBinderThumbnailUrl($binder),
            ];
            return $visible;
        });

        Log::debug($response);
        return $response;
    }
}