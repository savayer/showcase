<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CopyController extends Controller
{
    public function site(Request $request)
    {
        $site_id = $request->input('site_id');
        if ($site_id)
        {
            //$results = 'пришел ко мне сайт: '.$site_id;
            $new_site = DB::table('sites')->where('id', $site_id)->get();
            $new_sites_teasers = DB::table('sites_teasers')->select('site_id', 'teaser_id', 'num_order')->where('site_id', $site_id)->get()->toArray();
            $new_sites_articles = DB::table('sites_articles')->select('site_id', 'article_id', 'num_order')->where('site_id', $site_id)->get()->toArray();

            unset($new_site[0]->id);
            $new_site[0]->name = $new_site[0]->name.' Копия';

            DB::table('sites')->insert((array) $new_site[0]);

            $new_site_id = DB::table('sites')->select('id')->orderBy('id', 'desc')->limit(1)->get()[0]->id;

            foreach($new_sites_teasers as $key => $value) {
              $new_sites_teasers[$key]->site_id = $new_site_id;
              DB::table('sites_teasers')->insert((array) $new_sites_teasers[$key]);
            }

            foreach($new_sites_articles as $key => $value) {
              $new_sites_articles[$key]->site_id = $new_site_id;
              DB::table('sites_articles')->insert((array) $new_sites_articles[$key]);
            }

            $results = '';

            // DB::table('sites_teasers')->insert((array) $new_sites_teasers);
            // DB::table('sites_teasers')->insert((array) $new_sites_articles);
        }
        else
        {
            $results = 'Error';
        }

        return $results;
    }

}
