<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    //
    public function index(){
        
        $articles= Article::orderBy('created_at')->paginate(10);
        return view('home', compact('articles'));
        // TODO: extra stuff, make it so that home when logged in displays articles from subscribed/followed writers and 3 newest. At the very least on the first page. then when paginating go with just newest that havent been displayed yet.
        

    }
}
