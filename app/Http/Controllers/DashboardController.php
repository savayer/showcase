<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{

  function index() {
    $userId = auth()->user()->id;
    $countSites = $countTeasers = $countArticles = 0;

    $sites = DB::table('sites')
            ->join('countries', 'countries.id', '=', 'sites.country_id')
            ->where('sites.user_id', $userId)
            ->get();

    $tmp = []; //после применим array_count_values для получения количества сайтов по каждой стране
    $pop = []; $binom = []; $native = [];
    foreach ($sites as $key => $value) {
       $tmp[] = $sites[$key]->name;
       // if ($sites[$key]->type == 'pop') $pop[] = $sites[$key]->name;
       // if ($sites[$key]->type == 'native') $native[] = $sites[$key]->name;
       // if ($sites[$key]->type == 'binom') $binom[] = $sites[$key]->name;

    }
    $countSites   = count($tmp);
    $chartCountry = array_count_values($tmp);
    // $chartCountryPop = array_count_values($pop);
    // $chartCountryNative = array_count_values($native);
    // $chartCountryBinom = array_count_values($binom);

    /**************************************************/
    /**************************************************/
    /**************************************************/

    $teasers = DB::table('teasers')
              ->join('countries', 'countries.id', '=', 'teasers.country_id')
              ->where('user_id', $userId)
              ->get();

    $tmp = []; //после применим array_count_values для получения количества сайтов по каждой стране
    foreach ($teasers as $key => $value) {
       $tmp[] = $teasers[$key]->name;

    }
    $countTeasers = count($tmp);
    $chartTeasers = array_count_values($tmp);

    /**************************************************/
    /**************************************************/
    /**************************************************/

    $articles = DB::table('articles')
              ->join('countries', 'countries.id', '=', 'articles.country_id')
              ->where('user_id', $userId)
              ->get();

    $tmp = []; //после применим array_count_values для получения количества сайтов по каждой стране
    foreach ($articles as $key => $value) {
       $tmp[] = $articles[$key]->name;

    }
    $countArticles = count($tmp);
    $chartArticles = array_count_values($tmp);

    /**************************************************/
    /**************************************************/
    /**************************************************/

    $articles = DB::table('articles')
                ->join('categories', 'categories.id', '=', 'articles.category_id')
                ->where('user_id', $userId)
                ->get();

    $tmp = []; //после применим array_count_values для получения количества сайтов по каждой стране
    foreach ($articles as $key => $value) {
       $tmp[] = $articles[$key]->name;

    }
    $chartArticleCategory = array_count_values($tmp);

    return view('dashboard_custom', [
      'sites' => $countSites,
      'chartCountry' => $chartCountry,
      'articles' => $countArticles,
      'chartArticleCategory' => $chartArticleCategory,
      'teasers' => $countTeasers,
      'chartTeasers' => $chartTeasers,
      'chartArticles' => $chartArticles,
      // 'chartCountryPop' => $chartCountryPop,
      // 'chartCountryNative' => $chartCountryNative,
      // 'chartCountryBinom' => $chartCountryBinom
    ]);
  }

}
