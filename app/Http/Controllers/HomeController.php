<?php
namespace App\Http\Controllers;

/**
 * 기본 화면들
 */
class HomeController extends Controller
{
    public function index()
    {
        $user = $this->user;
        return view('home.index', get_defined_vars());
    }
}