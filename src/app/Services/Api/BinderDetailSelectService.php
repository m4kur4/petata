<?php

namespace App\Services\Api;

use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Carbon\Carbon;
use Log;

/**
 * @inheritdoc
 */
class BinderDetailSelectService implements BinderDetailSelectServiceInterface
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
    public function execute(string $binder_id)
    {
        $binder = $this->binder_repository->selectOneById($binder_id);

        $response = [
            'id' => $binder->id,
            'name' => $binder->name,
            'description' => $binder->description,
            'count_user' => $binder->binderAuthorities->count(),
            'count_image' => $binder->images->count(), 
            'count_label' => $binder->labels->count(),
            'count_favorite' => $binder->binderfavorites->count(),
            'labels' => $binder->labels
                ->sortBy('sort')
                ->values()
                ->all(),
            'images' => $binder->images
                ->sortBy('sort')
                ->values()
                ->all(),
            'created_at' => (new Carbon($binder->created_at))->format('Y/m/d')
        ];
        // NOTE: Collection::sortByDesc()は「元の配列キーを保持した新たなコレクション」を生成する
        return $response;
    }
}