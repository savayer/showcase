<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Teaser;

class TeasersController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->input('select_lang_id');
        $user_id = $request->input('user_id');
        if ($lang)
        {
            $results = Teaser::where('lang_id', $lang)
                       ->where('user_id', $user_id)->get();
        }
        else
        {
            $results = 'Error';
        }

        return $results;
    }
    //
    public function show($id)
    {
        return $id;
    }

    // public function index(Request $request) {
    //     dd($request);
    // }

}
