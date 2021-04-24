<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\Request;

class PostRequest extends Request
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
     * 獲取適用於請求的驗證規則。
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'            => 'sometimes|integer|exists:rhinoforum.user,id',
            'category'           => 'sometimes|string',
            'content'            => 'sometimes|string',
            'published_at_start' => 'sometimes|date_format:Y-m-d H:i:s',
            'published_at_end'   => 'sometimes|date_format:Y-m-d H:i:s',
            'per_page'           => 'sometimes|integer',
            'current_page'       => 'sometimes|integer',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id'            => '作者編號',
            'category'           => '文章分類',
            'content'            => '文章內容',
            'published_at_start' => '發佈起始時間',
            'published_at_end'   => '發佈結束時間',
            'per_page'           => '指定頁數',
            'current_page'       => '每頁資料比數',
        ];
    }
}
