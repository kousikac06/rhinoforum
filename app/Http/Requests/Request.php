<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    /**
     * 確定用戶是否有權發出此請求。
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all requests and handle authorization in controllers.
        return true;
    }

    /**
     * 處理失敗的驗證嘗試。
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'result' => 'error',
                'errors' => $validator->errors(),
            ], 200, [], JSON_UNESCAPED_UNICODE)
        );
    }

    public function messages()
    {
        return [
            'integer'     => ':attribute，必須為數字',
            'string'      => ':attribute，必須為字串',
            'date_format' => ':attribute，格式必須為Y-m-d H:i:s (ex: 2021-01-01 13:01:01)',
            'exists'      => ':attribute，不存在',
        ];
    }
}
