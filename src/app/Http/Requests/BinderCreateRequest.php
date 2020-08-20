<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        if (empty($this->label_name)) {
            return;
        }

        $labels = [];
        foreach($this->label_names as $index => $label_name) {
            $label = ['name' => $label_name, 'description' => ''];
            if (empty($this->label_descriptions)) {
                // ラベルに説明がない場合
                array_push($labels, $label);
                continue;
            }
            if (array_key_exists($index, $this->label_descriptions)) {
                // TODO: 説明がある場合の処理
            }
        }
        // 日時をデータに追加
        $date_time = ($this->filled(['date', 'time'])) ? $this->date .' '. $this->time : '';
        $this->merge([
           'date_time' => $date_time
        ]);
    }
}
