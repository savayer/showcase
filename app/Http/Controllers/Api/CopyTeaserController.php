<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CopyTeaserController extends Controller
{
    public function index(Request $request)
    {
        
       
       
        $teaser_id = $request->input('teaser_id');
        
       
        if ($teaser_id)
        {
            
      
            $new_teaser = DB::table('teasers')->where('id', $teaser_id)->get();            
            unset($new_teaser[0]->id);
            $new_teaser[0]->text = 'КОПИЯ — '.$new_teaser[0]->text;
            if ($new_teaser[0]->gif) {
              $gif_original = $new_teaser[0]->image1gif;
              $image_original = str_replace('uploads', '', $new_teaser[0]->image);
              $gif_copied = '/user_' . auth()->user()->id .'/'. md5(time()).'.gif';
              $image_copied = '/user_' . auth()->user()->id .'/'. md5(time()).'.jpg';
              \Storage::disk('uploads')->copy($gif_original, $gif_copied);
              \Storage::disk('uploads')->copy($image_original, $image_copied);
              $new_teaser[0]->image1gif = $gif_copied;
              $new_teaser[0]->image = 'uploads' . $image_copied;
              DB::table('teasers')->insert((array) $new_teaser[0]);
            } else {
              $image_original = str_replace('uploads', '', $new_teaser[0]->image);
              $image2_original = str_replace('uploads', '', $new_teaser[0]->image2);
              $image_copied = '/user_' . auth()->user()->id .'/'. md5(time()).'.jpg';
              $image2_copied = '/user_' . auth()->user()->id .'/'. md5( md5(time()) ).'.jpg';
              \Storage::disk('uploads')->copy($image_original, $image_copied);
              \Storage::disk('uploads')->copy($image2_original, $image2_copied);
              $new_teaser[0]->image = 'uploads' . $image_copied;
              $new_teaser[0]->image2 = 'uploads' . $image2_copied;
              DB::table('teasers')->insert((array) $new_teaser[0]);
            }


            $results = (array) $new_teaser[0];


        }
        else
        {
            $results = 'Error';
        }

        return $results;
    }

}
