<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 取得分頁參數22
     *
     * @param $formData
     * @return mixed
     */
    public function getPaginationParameter($formData)
    {
        $formData['start'] = ($formData['current_page'] - 1) * $formData['per_page'];
        $formData['limit'] = $formData['per_page'];

        return $formData;
    }
}
