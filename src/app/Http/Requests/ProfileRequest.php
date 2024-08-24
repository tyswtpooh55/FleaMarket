<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'img_url' => ['nullable', 'image', 'max:2048'],
            'postcode' => ['required', 'regex:/^\d{3}-?\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'img_url.image' => '画像ファイルをアップロードしてください',
            'img_url.max' => '画像サイズは2MB以下でアップロードしてください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号は「123-4567」または「1234567」の形式で入力して下さい',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は:max文字以下で入力してください',
            'building.string' => '建物名は文字列で入力してください',
            'building.max' => '建物名は:max文字以下で入力してください'
        ];
    }
}
