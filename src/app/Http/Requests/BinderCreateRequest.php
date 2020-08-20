<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Log;

class BinderCreateRequest extends FormRequest
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
        return [
            //
        ];
    }

    /**
     * POSTされたデータをバリデーション前に加工します。
     *
     * @see Illuminate\Foundation\Http\FormRequest::prepareForValidation()
     * @return void
     */
    protected function prepareForValidation()
    {
        // ラベル情報を変換
        $this->convertLabelPost();
    }

    /**
     * POSTされたラベル情報を連想配列へ変換します。
     */
    private function convertLabelPost()
    {
        if (empty($this->label_names)) {
            return;
        }

        $labels = [];
        foreach($this->label_names as $index => $label_name) {
            $label = ['name' => $label_name, 'description' => ''];

            if (empty($this->label_descriptions)) {
                // 説明の付与されたラベルが一つもない場合
                array_push($labels, $label);
                continue;
            }

            if (array_key_exists($index, $this->label_descriptions)) {
                // 説明の付与されたラベルの場合
                $label['description'] = $this->label_descriptions[$index];
            }
            array_push($labels, $label);
        }

        $this->merge([
           'labels' => $labels
        ]);
    }
}
