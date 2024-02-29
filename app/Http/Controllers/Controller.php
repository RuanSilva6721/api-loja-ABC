<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Adoorei Teste",
 *     version="0.1",
 *     description="Criando uma API rest, A Loja ABC LTDA, vende produtos",
 *      @OA\Contact(
 *          email="ruansilva6721@gmail.com",
 *          name="Ruan Silva"
 *      ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
