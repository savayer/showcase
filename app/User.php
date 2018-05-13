<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function teasers()
    {
      return $this->hasMany(\App\Models\Teaser::class);
    }

    public function articles()
    {
      return $this->hasMany(\App\Models\Article::class);
    }

    public static function getTeasersForCrudIOptions(self $user)
    {
      $teasers = $user->teasers()->get();

      if (empty($teasers) || count($teasers) == 0) {
        return null;
      }
      $result = [];
//dd($teasers);
      foreach ($teasers as $teaser) {
        $result[$teaser->id] = array(
          0 => $teaser->text,
          1 => $teaser->image,
          2 => $teaser->lang_id
        );
        //$result[$teaser->id] = $teaser->text;
      }

      // dd($result);

      return $result;
    }

    public static function getArticlesForCrudIOptions(self $user)
    {
      $articles = $user->articles()->get();

      if (empty($articles) || count($articles) == 0) {
        return null;
      }
      $result = [];

      foreach ($articles as $article) {
        //$result[$article->id] = $article->name;
        $result[$article->id] = array(
          0 => $article->name,
          1 => $article->image,
          2 => $article->category_id,
          3 => $article->country_id
        );
      }

      return $result;
    }
}
