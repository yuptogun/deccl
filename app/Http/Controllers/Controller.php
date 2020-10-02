<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * 총괄 공통 컨트롤러
 */
class Controller extends BaseController
{
    public $user;

    public function __construct()
    {
        $this->user = request()->user;
    }
}