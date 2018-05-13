<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Article;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->input('select_country_id');
        $user_id = $request->input('user_id');
        if ($lang)
        {
            $results = Article::select('categories.name as category', 'articles.name', 'articles.image', 'articles.id')
                       ->join('categories', 'categories.id', '=', 'articles.category_id')
                       ->where('country_id', $lang)
                       ->where('user_id', $user_id)->get();
        }
        else
        {
            $results = 'Error';
        }

        return $results;
    }

}
