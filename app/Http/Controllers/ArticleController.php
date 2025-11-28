<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Mock data if database is empty for UI visualization
        $articles = Article::orderBy('published_at', 'desc')->get();
        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('articles.show', compact('article'));
    }
}
