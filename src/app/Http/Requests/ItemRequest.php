<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'brand' => ['nullable', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'condition_id' => ['required', 'integer', 'exists:conditions,id'],
            'category_id_1' => ['required', 'integer', 'exists:categories,id'],
            'category_id_2' => ['nullable', 'integer', 'exists:categories,id'],
            'img_url.*' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は:max文字以下で入力してください',
            'brand.string' => 'ブランド名は文字列で入力してください',
            'brand.max' => 'ブランド名は:max文字以下で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値で入力してください',
            'description.required' => '商品説明を入力してください',
            'condition_id.required' => '商品の状態を選択してください',
            'condition_id.exists' => '選択された商品の状態は無効です',
            'category_id_1.required' => 'カテゴリー1を選択してください',
            'category_id_1.exists' => '選択されたカテゴリーは無効です',
            'category_id_2.exists' => '選択されたカテゴリーは無効です',
            'img_url.*.image' => '画像ファイルをアップロードしてください',
            'img_url.*.max' => '画像サイズは2MB以下でアップロードしてください'
        ];
    }
}
