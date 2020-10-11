<?php
namespace App\Http\Controllers;

/**
 * 기본 화면들
 */
class UserController extends Controller
{
    public function create()
    {
        $title = '회원가입';
        return view('user.create', get_defined_vars());
    }

    public function store()
    {
        # code...
    }
}