<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\User;
use App\Models\Category;
use App\Models\Country;
use App\Models\Lang;

class Article extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'intro', 'image', 'text', 'user_id', 'country_id', 'lang_id', 'category_id', 'context_name', 'context_description'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $user_path = '/user_'.auth()->user()->id;
        $destination_path = "uploads";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($user_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.$user_path.'/'.$filename;
            //chmod($destination_path.$user_path, 0755);
            // chmod($this->attributes[$attribute_name], 644);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /*public function site()
    {
        return $this->hasOne(Sites::class, 'id', 'site_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }*/
    public function category()
    {
      return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function country()
    {
      return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function lang()
    {
      return $this->hasOne(Lang::class, 'id', 'lang_id');
    }

    public static function getUniqueCountryIds() {
      return Article::select('country_id')->groupBy('country_id')->get()->toArray();
    }

    public static function boot()
    {

        parent::boot();
        static::deleting(function($obj) {
          $re = '/(.*)(\/)/';
          //$str = 'uploads/user_2/cc936362fbf856dc7a3debf49133c37a.jpg';
          $str = $obj->image;
          $subst = '';
          $result = preg_replace($re, $subst, $str);

          \Storage::disk('uploads')->delete('/user_'.auth()->user()->id.'/'.$result);
        });
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
