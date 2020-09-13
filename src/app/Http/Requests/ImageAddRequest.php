<?php

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

use Log;

class ImageAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $binder_id = $this->binder_id;
        return [
            'images' => [
                // バインダーあたりの画像数上限チェック
                function($attribute, $value, $fail) use($binder_id) {
                    
                    // アップロード後に30ファイル以上となる場合はエラー
                    $file_count_limit = 30;
                    $file_count_exist = Image::query()
                        ->where('binder_id', $binder_id)
                        ->count();
                    
                    $file_count_after = count($value) + $file_count_exist;
                    $is_limit_over = $file_count_after > $file_count_limit;

                    if ($is_limit_over) {
                        return $fail(__('message.VALIDATION.IMAGE_ADD.FILE_COUNT'));
                    }
                },
            ],
            'images.*' => [
                'mimes:bmp,jpeg,png',
                'max:5120',
            ]
        ];
    }

    public function messages()
    {
        return [
            'images.*.max' => __('message.VALIDATION.IMAGE_ADD.MAX_MB')
        ];
    }

    protected function prepareForValidation()
    {
        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':max_in_mb', $parameters[0] / 1024, $message);
        });
    }
}
