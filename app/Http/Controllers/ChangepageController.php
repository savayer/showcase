<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ChangepageController extends Controller
{

  function index(Request $request, $type_links, $lang, $siteId) {
    $addjs = DB::table('sites')
                 ->where('id', $siteId)
                 ->get()[0]->addjs;
    $teasers = DB::table('sites_teasers')
                  ->join('teasers', 'teasers.id', '=', 'sites_teasers.teaser_id')
                  ->where('site_id', $siteId)
                  ->inRandomOrder()
                  ->get()
                  ->toArray();
    if ($type_links == 'pop') {
      $link = '{link|purchanger.com}/';
      foreach ($teasers as $key => $value) {
        if ($teasers[$key]->num_order > 1) {
          $teasers[$key]->num_order = $teasers[$key]->num_order+1;
        }
      }
    } else if ($type_links == 'native') {
      $link = '{link|trauwt.com}/';
    } else if ($type_links == 'binom') {
      $link = 'http://wttrack.com/click.php?lp=';
    }

    return view('change', [
      'addjs' => $addjs,
      'link' => $link,
      'teasers' => $teasers
    ]);
  }

}
