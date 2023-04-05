<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
 /**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Assemble Yourself",
 *      description="Приложение для личностного роста",
 *      @OA\Contact(
 *          email="v.a.kuznetsov-83@yandex.ru"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
