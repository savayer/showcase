<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\User;
use App\Models\Country;
use App\Models\Lang;

class Teaser extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'teasers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['image', 'text', 'user_id', 'country_id', 'lang_id', 'image2', 'image1gif', 'gif'];

    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function setImageAttribute($value)
    {
      //dd($value);
      // //dd(substr($value, 22, strlen($value)-22));
      // $value = substr($value, 22, strlen($value)-22);
      // //str_replace('data:image/png;base64,', '', $value)
      // $imageBlob = base64_decode($value);
      //
      // $imagick = new \Imagick();
      // $imagick->readImageBlob($imageBlob);
      //
      // header("Content-Type: image/gif");
      // die($imagick);
        $attribute_name = "image";
        $disk = "uploads";
        $user_path = '/user_'.auth()->user()->id;
        $destination_path = "uploads";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            //$image->resize(250); //492х328  250, 167
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($user_path.'/'.$filename, $image->stream());
            $this->attributes[$attribute_name] = $destination_path.$user_path.'/'.$filename;
        }
    }
    public function setImage2Attribute($value)
    {
      //dd($value);
        $attribute_name = "image2";
        $disk = "uploads";
        $user_path = '/user_'.auth()->user()->id;
        $destination_path = "uploads";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
        //    dd($image);
            //$image->resize(120, 120);
            //dd($image->response($image->mime()));
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($user_path.'/'.$filename, $image->stream());
            $this->attributes[$attribute_name] = $destination_path.$user_path.'/'.$filename;
            //die('<img src="'.$value.'">');
        }
    }
    public function setImage1gifAttribute($value)
    {
      // dd($value);
      $attribute_name = "image1gif";
      $disk = "uploads";
      $user_path = '/user_'.auth()->user()->id;

/******************************************************/
      $image = new \Imagick();
      if (!empty($value)) {
        $image->readImage($value);

        $countFrames = $image->getNumberImages();
        $filename_without_extension = md5($value.time());


        if ($image->getImageFormat() == 'GIF') {
          $image = $image->coalesceImages();
          $width = $image->getImageWidth();
          $height = $image->getImageHeight();
          if ($width > $height) {
            $crop_w = $height; $crop_h = $height;
            $crop_x = ($width-$height) / 2;
            // $crop_y = $width - (($width-$height) / 2);
            $crop_y = 0;
          } else if ($width < $height) {
            $crop_w = $width; $crop_h = $width;
            $crop_y = ($height-$width) / 2;
            $crop_x = 0;
            // $crop_y = $height - (($height-$width) / 2);
          } else {
            $crop_w = 200; $crop_h = 200;
            $crop_x = 0; $crop_y = 0;
          }


          $size_w = 200; $size_h = 200;

          $counterFrames = 0;
          foreach ($image as $frame) {
            $counterFrames++;
            $frame->cropImage($crop_w, $crop_h, $crop_x, $crop_y);
            $frame->thumbnailImage($size_w, $size_h);
            $frame->setImagePage($size_w, $size_h, 0, 0);
            if ($countFrames == $counterFrames) {
              $file_out = $disk.'/'.$user_path.'/'.$filename_without_extension.'.jpg';
              $this->attributes['image'] = $file_out;
              $image->writeImage($file_out);
            }
          }

          $image = $image->deconstructImages();
          $filename = $filename_without_extension.'.gif';
          $file_out = $disk.'/'.$user_path.'/'.$filename;
          $this->attributes[$attribute_name] = $user_path.'/'.$filename;
          $image->writeImages($file_out, true);

          //
          // $image = \Image::make($value);
          // $filename = $filename_without_extension.'.jpg';
          // \Storage::disk($disk)->put($user_path.'/'.$filename, $image->stream());
          // $this->attributes['image'] = $disk.$user_path.'/'.$filename;
        }

      }

    }
    // public function setImage2gifAttribute($value)
    // {
    //       $attribute_name = "image2";
    //       $disk = "uploads";
    //       $user_path = '/user_'.auth()->user()->id;
    //       //$this->attributes[$attribute_name] = $disk.$user_path.'/'.$value;
    //       $this->uploadFileToDisk($value, $attribute_name, $disk, $user_path);
    //   }
    public static function boot()
    {

        parent::boot();
        static::deleting(function($obj) {
          $re = '/(.*)(\/)/';
          //$str = 'uploads/user_2/cc936362fbf856dc7a3debf49133c37a.jpg';
          $str = $obj->image;
          if (!empty($str)) {
            $subst = '';
            $result = preg_replace($re, $subst, $str);
            \Storage::disk('uploads')->delete('/user_'.auth()->user()->id.'/'.$result);
          }

          $str2 = $obj->image2;
          if (!empty($str2)) {
            $subst = '';
            $result2 = preg_replace($re, $subst, $str2);
            \Storage::disk('uploads')->delete('/user_'.auth()->user()->id.'/'.$result2);
          }

          $str3 = $obj->image1gif;
          if (!empty($str3)) {
            $subst = '';
            $result3 = preg_replace($re, $subst, $str3);
            \Storage::disk('uploads')->delete('/user_'.auth()->user()->id.'/'.$result3);
          }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function lang()
    {
        return $this->hasOne(Lang::class, 'id', 'lang_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
