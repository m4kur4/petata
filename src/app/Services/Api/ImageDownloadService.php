<?php

namespace App\Services\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\Api\Interfaces\ImageDownloadServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use FileManageHelper;
use Log;
use Storage;
use Zip;

/**
* @inheritdoc
*/
class ImageDownloadService implements ImageDownloadServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param ImageRepositoryInterface $image_repository
     */
    public function __construct(
        ImageRepositoryInterface $image_repository
    )
    {
        $this->image_repository = $image_repository;
    }
  
    /**
     * @inheritdoc
     */
    public function execute(Request $request)
    {
        $images = Image::query()
            ->whereIn('id', $request->image_ids)
            ->get();
            
        $FILE_NAME = 'binder.zip';
        $zip = Zip::create($FILE_NAME);

        // FIXME: マルチバイト文字がファイル名に設定できないため、ファイル名をインデックスとしている
        foreach($images as $index => $image) {
            $file_path = FileManageHelper::getBinderImageS3Path($image);
            $file_name = $index . '.' . $image->extension;
            $zip->add($file_path, $file_name);
        }
        return $zip;
    }
}