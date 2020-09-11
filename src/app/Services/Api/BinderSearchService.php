<?php

namespace App\Services\Api;

use App\Services\Api\Interfaces\BinderSearchServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Illuminate\Http\Request;

use Log;

/**
 * @inheritdoc
 */
class BinderSearchService implements BinderSearchServiceInterface
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
    public function execute(Request $request)
    {
        $binders = $this->binder_repository->search($request);
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
                    ->all()
            ];
            return $visible;
        });

        return $response;
    }

}