<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Sites;
use App\Models\Teaser;
use App\User;


class PageinsideController extends Controller
{
    function index(Request $request, $type_links, $lang, $siteId, $siteType, $category, $article_id) {
      if ($type_links == 'pop') {
        $link = '{link|purchanger.com}/';
      } else if ($type_links == 'native') {
        $link = '{link|trauwt.com}/';
      } else if ($type_links == 'binom') {
        $link = 'http://wttrack.com/click.php?lp=1&to_offer=';
      }
      $addjs = DB::table('sites')
                 ->where('id', $siteId)
                 ->get()[0]->addjs;
      $country = DB::table('sites')
                 ->select('countries.fullname')
                 ->join('countries', 'countries.id', '=', 'sites.country_id')
                 ->where('sites.id', $siteId)
                 ->get();
      $categories = Category::all();
      $categoriesSlugs = array('politics' => 1, 'economics' => 2, 'horo' => 3, 'health' => 4, 'show-business' => 5, 'dating' => 6,'finance' => 7);
      $categoriesNames = array(
        'politics' => 'Политика',
        'economics' => 'Экономика',
        'horo' => 'Гороскопы',
        'health' => 'Здоровье',
        'show-business' => 'Шоу-биз',
        'dating' => 'Знакомства',
        'finance' =>'Финансы'
      );
      $articles = DB::table('sites_articles')
                  ->select('articles.*', 'categories.name as category_name', 'categories.slug')
                  ->join('articles', 'articles.id', '=', 'sites_articles.article_id')
                  ->join('categories', 'articles.category_id', '=', 'categories.id')
                  ->where('sites_articles.site_id', $siteId)
                  ->where('articles.category_id', $categoriesSlugs[$category])
                  ->where('sites_articles.article_id','<>', $article_id) //ИСКЛЮЧАЕМ ВЫБРАННУЮ НОВОСТЬ ИЗ ВЫБОРКИ
                  ->orderBy('num_order')
                  ->get()
                  ->toArray();
      $firstArticle = DB::table('articles')->where('id', $article_id)->get();

      if ($type_links == 'native' || $type_links == 'binom') {
        $teasers = DB::table('sites_teasers')
                      ->join('teasers', 'teasers.id', '=', 'sites_teasers.teaser_id')
                      ->where('site_id', $siteId)
                      ->inRandomOrder()
                      //->orderBy('num_order')
                      ->get()
                      ->toArray();
        $teasersTop3 = array_slice($teasers, 0, 3);
        $teasersRight4 = array_slice($teasers, 3, 6);
        $teasersRecommend = array_slice($teasers, 9, 5);
        $teasersActual = array_slice($teasers, 14, 5);
      } else if ($type_links == 'pop') {
        $teasers = DB::table('sites_teasers')
                      ->join('teasers', 'teasers.id', '=', 'sites_teasers.teaser_id')
                      ->where('site_id', $siteId)
                      ->inRandomOrder()
                      //->orderBy('num_order')
                      ->get()
                      ->toArray();
        foreach ($teasers as $key => $value) {
          if ($teasers[$key]->num_order > 1) {
            $teasers[$key]->num_order = $teasers[$key]->num_order+1;
          }
        }

        $teasersTop3 = array_slice($teasers, 0, 3);
        $teasersRight4 = array_slice($teasers, 3, 5);
        $teasersRecommend = array_slice($teasers, 8, 5);
        $teasersActual = array_slice($teasers, 13, 5);
      }
      $new_articles = array_slice($articles, 0, 4);
      if ($siteType == 'cl') {
        return view('preview_inside', [
          'addjs' => $addjs,
          'country' => $country,
          'siteType' => $siteType,
          'firstArticle' => $firstArticle,
          'articles' => $new_articles,
          'teasersTop3' => $teasersTop3,
          'teasersRight4' => $teasersRight4,
          'teasersRecommend' => $teasersRecommend,
          'teasersActual' => $teasersActual,
          'categories' => $categories,
          'categoryNow'=>$categoriesNames[$category],
          'link' => $link,
          'routeParams' => array_slice(request()->route()->parameters, 0, 5)
        ]);
      }
      return view('preview_inside', [
        'addjs' => $addjs,
        'country' => $country,
        'type_links' => $type_links,
        'siteType' => $siteType,
        'firstArticle' => $firstArticle,
        'articles' => $new_articles,
        'teasersTop3' => $teasersTop3,
        'teasersRight4' => $teasersRight4,
        'teasersRecommend' => $teasersRecommend,
        'teasersActual' => $teasersActual,
        'categories' => $categories,
        'categoryNow'=>$categoriesNames[$category],
        'link' => $link,
        'routeParams' => array_slice(request()->route()->parameters, 0, 5)
      ]);
    }

}
