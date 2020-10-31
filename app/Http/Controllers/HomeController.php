<?php
namespace App\Http\Controllers;

use App\Models\Comment;

/**
 * 기본 화면들
 */
class HomeController extends Controller
{
    public function index()
    {
        $user = $this->user;
        $recentComments = Comment::with('article')->recent()->latest()->get();
        return view('home.index', get_defined_vars());
    }
}