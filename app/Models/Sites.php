<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\User;
use App\Models\Article;
use App\Models\Teaser;

class Sites extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sites';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'type', 'geo', 'user_id', 'country_id', 'lang_id', 'url1', 'url2', 'url3', 'url4', 'addjs'];
    // protected $hidden = [];
    // protected $dates = [];


    protected $something = [
        'articlesIds', 'teasersIds',
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'sites_articles', 'site_id', 'article_id')->withPivot('num_order');
    }

    public function teasers()
    {
        return $this->belongsToMany(Teaser::class, 'sites_teasers', 'site_id', 'teaser_id')->withPivot('num_order');
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

    public function getTeasersIdsAttribute()
    {
      if (empty($this->teasers)) {
        return [];
      }
      return $this->teasers->pluck('id')->all();
    }

    public function getArticlesIdsAttribute()
    {
      if (empty($this->articles)) {
        return [];
      }
      return $this->articles->pluck('id')->all();
    }
}
