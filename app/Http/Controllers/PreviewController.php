<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Sites;
use App\Models\Teaser;
use App\User;


class PreviewController extends Controller
{
    function index($type_links, $lang, $siteId, $siteType) {
        if ($type_links == 'pop') {
          $link = '{link|purchanger.com}/';
        } else if ($type_links == 'native') {
          $link = '{link|trauwt.com}/';
        } else if ($type_links == 'binom') {
          $link = 'http://wttrack.com/click.php?lp=1&to_offer=';
        }
        $categories = Category::all();
        $categoriesArray = array(
          'politics' => 1,
          'economics' => 2,
          'horo' => 3,
          'health' => 4,
          'show-business' => 5,
          'dating' => 6,
          'finance' => 7
        );
        $addjs = DB::table('sites')
                 ->where('id', $siteId)
                 ->get()[0]->addjs;


        $country = DB::table('sites')
                   ->select('countries.fullname')
                   ->join('countries', 'countries.id', '=', 'sites.country_id')
                   ->where('sites.id', $siteId)
                   ->get();

        $teasers = DB::table('sites_teasers')
                      ->join('teasers', 'teasers.id', '=', 'sites_teasers.teaser_id')
                      ->where('site_id', $siteId)
                      ->inRandomOrder()
                      ->get()
                      ->toArray();
        if ($type_links == 'pop') {
          foreach ($teasers as $key => $value) {
            if ($teasers[$key]->num_order > 1) {
              $teasers[$key]->num_order = $teasers[$key]->num_order+1;
            }
          }
        }
        $teasersLeft = array_slice($teasers, 0, 10);
        $teasersRight = array_slice($teasers, 10, 10);

        if ($siteType == 'full') {
          if ($type_links == 'pop') {
            $articles = DB::table('sites_articles')
                        ->select('articles.*', 'categories.name as category_name', 'categories.slug')
                        ->join('articles', 'articles.id', '=', 'sites_articles.article_id')
                        ->join('categories', 'articles.category_id', '=', 'categories.id')
                        ->where('sites_articles.site_id', $siteId)
                        ->orderBy('num_order')
                        ->limit(4)
                        ->get()
                        ->toArray();
          }
          else if ($type_links == 'native' || $type_links == 'binom') {
            $articles = DB::table('sites_articles')
                        ->select('articles.*', 'categories.name as category_name', 'categories.slug')
                        ->join('articles', 'articles.id', '=', 'sites_articles.article_id')
                        ->join('categories', 'articles.category_id', '=', 'categories.id')
                        ->where('sites_articles.site_id', $siteId)
                        ->orderBy('num_order')
                        ->limit(5)
                        ->get()
                        ->toArray();
          }
            $firstArticle = array_slice($articles, 0, 1);
            unset($articles[0]);
            if ($type_links == 'native' || $type_links == 'binom') {
              $teasersTop3 = array_slice($teasers, 0, 3);
              $teasersRight4 = array_slice($teasers, 3, 6);
              $teasersRecommend = array_slice($teasers, 9, 5);
              $teasersActual = array_slice($teasers, 14, 5);
            } else if ($type_links == 'pop') {
              $teasersTop3 = array_slice($teasers, 0, 3);
              $teasersRight4 = array_slice($teasers, 3, 5);
              $teasersRecommend = array_slice($teasers, 8, 5);
              $teasersActual = array_slice($teasers, 13, 5);
            }
//dd($teasersTop3);
          return view('preview_inside', [
            'addjs' => $addjs,
            'country' => $country,
            'type_links' => $type_links,
            'siteType' => $siteType,
            'firstArticle' => $firstArticle,
            'articles' => $articles,
            'teasersTop3' => $teasersTop3,
            'teasersRight4' => $teasersRight4,
            'teasersRecommend' => $teasersRecommend,
            'teasersActual' => $teasersActual,
            'categories' => $categories,
            'categoryNow'=>'',
            'link' => $link,
            'routeParams' => request()->route()->parameters
          ]);
        }
        if ($siteType == 'preview') {
          $articles = DB::table('sites_articles')
                      ->select('articles.*', 'categories.name as category_name', 'categories.slug')
                      ->join('articles', 'articles.id', '=', 'sites_articles.article_id')
                      ->join('categories', 'articles.category_id', '=', 'categories.id')
                      ->where('sites_articles.site_id', $siteId)
                      ->limit(7)
                      ->orderBy('num_order')
                      ->get()
                      ->toArray();
          return view('preview', [
            'addjs' => $addjs,
            'country' => $country,
            'siteType' => $siteType,
            'articles' => $articles,
            'teasersLeft' => $teasersLeft,
            'teasersRight' => $teasersRight,
            'categories' => $categories,
            'link' => $link,
            'routeParams' => request()->route()->parameters
          ]);
        }
        if ($siteType == 'cl') {
          $articles = DB::table('sites_articles')
                      ->select('articles.*', 'categories.name as category_name', 'categories.slug')
                      ->join('articles', 'articles.id', '=', 'sites_articles.article_id')
                      ->join('categories', 'articles.category_id', '=', 'categories.id')
                      ->where('sites_articles.site_id', $siteId)
                      ->limit(5)
                      ->orderBy('num_order')
                      ->get()
                      ->toArray();
          $firstArticle = array_slice($articles, 0, 1);
          unset($articles[0]);
          return view('preview_inside', [
            'addjs' => $addjs,
            'country' => $country,
            'siteType' => $siteType,
            'firstArticle' => $firstArticle,
            'articles' => $articles,
            'categories' => $categories,
            'categoryNow'=>'',
            'link' => $link,
            'routeParams' => request()->route()->parameters
          ]);
        }
    }

}
