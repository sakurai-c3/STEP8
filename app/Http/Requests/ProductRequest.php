<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // $request->validate は書かずに、配列 [ ] だけを返します
        return [
            'product_name' => 'required',
            'company_id'   => 'required',
            'price'        => 'required|integer',
            'stock'        => 'required|integer',
            'comment'      => 'nullable',
            'img_path'     => 'nullable|image',
        ];
    }

    /**
     * 2. エラーメッセージだけを記述する（メソッドを新しく追加します）
     */
    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required'   => 'メーカーを選択してください。',
            'price.required'        => '価格は必須項目です。',
            'price.integer'         => '価格は数値で入力してください。',
            'stock.required'        => '在庫数は必須項目です。',
            'stock.integer'         => '在庫数は数値で入力してください。',
        ];
    }
}