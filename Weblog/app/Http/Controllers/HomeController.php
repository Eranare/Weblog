<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Delegate to ArticleController for fetching articles
        return app(ArticleController::class)->index();
    }
}
