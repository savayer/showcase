<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\DB;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SitesRequest as StoreRequest;
use App\Http\Requests\SitesRequest as UpdateRequest;
use App\User;
use App\Models\Sites;
use App\Models\Lang;
use App\Models\Country;
use Illuminate\Http\Request;

class SitesCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Sites');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sites');
        $this->crud->setEntityNameStrings('sites', 'sites');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
        $this->crud->addColumn([
          'name' => 'name',
          'label' => 'Название'
        ]);
        $this->crud->addColumn([
          'name' => 'type',
          'label' => 'Тип'
        ]);
        $this->crud->addColumn([
           'label' => "Страна",
           'type' => "select",
           'name' => 'country_id',
           'entity' => 'country',
           'attribute' => "name",
           'model' => "App\Models\Country"
        ]);

        $this->crud->addColumn([
           'label' => "Язык",
           'type' => "select",
           'name' => 'lang_id',
           'entity' => 'lang',
           'attribute' => "fullname",
           'model' => "App\Models\Lang"
        ]);
        $this->crud->addColumn([
          'name' => 'url1',
          'label' => 'Превью',
          'type' => 'link'
        ]);
        $this->crud->addColumn([
          'name' => 'url2',
          'label' => 'Полная',
          'type' => 'link2'
        ]);
        $this->crud->addColumn([
          'name' => 'url3',
          'label' => 'Клоака',
          'type' => 'link3'
        ]);
        $this->crud->addColumn([
          'name' => 'url4',
          'label' => 'Доп',
          'type' => 'link4'
        ]);
        $this->crud->addColumn([
          'name' => 'addjs', // The db column name
          'label' => "push", // Table column heading
          'type' => 'check'
       ]);

        //  $this->crud->addButtonFromModelFunction('line', 'open_google', 'openGoogle', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model
        //$this->crud->addButton($stack, $name, $type, $content, $position);
        $this->crud->addButton('line', 'copy', 'view', 'crud::buttons.copy', 'end');
        //dd(env('APP_URL'));
        /*
        *
        * FILTERS
        *
        */

        $this->crud->addFilter([ // add a "simple" filter called Draft
          'type' => 'select2',
          'name' => 'country_id',
          'label'=> 'По стране'
        ],
        function() {
          $countries = DB::table('countries')->select('id', 'name')->get();
          $i = 1;
          foreach ($countries as $country) {
            $new_country[$i] = $country->name;
            $i++;
          }
          return $new_country;
        },
        function($value) {
          $this->crud->addClause('where', 'country_id', $value);
        });

        $this->crud->addFilter([ // add a "simple" filter called Draft
          'type' => 'select2',
          'name' => 'lang_id',
          'label'=> 'По языку'
        ],
        function() {
          $langs = DB::table('langs')->select('id', 'fullname')->get();
          $i = 1;
          foreach ($langs as $lang) {
            $new_langs[$i] = $lang->fullname;
            $i++;
          }
          return $new_langs;
        },
        function($value) {
          $this->crud->addClause('where', 'lang_id', $value);
        });

        /*
        *
        * FIELDS
        *
        */

        //$sites = Sites::with('num_order')->find(1);
        //dd($sites);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Название сайта'
        ]);
        $this->crud->addField([
            'name'        => 'type', // the name of the db column
            'label'       => 'Тип', // the input label
            'type'        => 'radio',
            'options'     => [
                                'pop' => "pop",
                                'native' => "native",
                                'binom' => 'binom RU'
                            ],
            'inline'      => true, // show the radios all on the same line?
        ]);

        $this->crud->addField([
          'name' => 'addjs',
          'label' => 'Добавить push',
          'type' => 'checkbox'
        ]);

        $countries = Country::getCountriesForCrudIOptions();
        $this->crud->addField([
           'label' => "Страна",
           'type' => 'select_from_array_custom',
           'options' => $countries,
           'name' => 'country_id',
           'allows_multiple' => false
        ], 'both');

        $langs = Lang::getLangsForCrudIOptions();
        $this->crud->addField([
           'label' => "Язык",
           'type' => 'select_from_array_custom',
           'options' => $langs,
           'name' => 'lang_id',
           'allows_multiple' => false
        ], 'both');

        $teasers = User::getTeasersForCrudIOptions(auth()->user());
        $articles = User::getArticlesForCrudIOptions(auth()->user());

        $this->crud->addField([
           'label' => "Тизеры",
            'type' => 'select2_from_array_teasers',
            'options' => $teasers,
           'name' => 'teasersIds',
           'allows_multiple' => true,
           'attributes' => [
             'data_type' => 'teasers'
           ],
           'wrapperAttributes' => [
             'class' => 'form-group col-md-12 type_data_teasers'
           ]
        ], 'create');



//$teasers - ВСЕ тизера принадлежащие текущему юзеру
        if (!empty($teasers)) {
          foreach ($teasers as $key => $value) {  //получаем айдишники всех тизеров
            $teasersKeys[] = $key;
          }
        }
        $teasers_update = [];
        $teasers_selected = [];
        $site_id = $this->getSiteIdFromRequestIfExists(); //получаем айди сайта который будет редактироваться
        if ($site_id != null) {
            $lang_id = DB::table('sites')
                    ->select('lang_id')
                    ->where('id', $site_id)
                    ->get()[0]
                    ->lang_id; //id языка редактируемого сайта

            $tmp = DB::table('sites_teasers')
            ->select('teaser_id')
            ->where('site_id', $site_id)
            ->whereIn('teaser_id', $teasersKeys)->orderBy('num_order')->get();

            foreach ($tmp as $key => $value) {
            	$teasers_selected[$value->teaser_id] = $teasers[$value->teaser_id]; //получаем прикрепленные тизеры
            	unset($teasers[$value->teaser_id]);
            }
//$teasers - получили недостающие тизеры (невыбранные). Осталось их почистить, путем удаления тизеров с языками не равными редактируемому
            foreach($teasers as $key => $teaser) {
              if ($teasers[$key][2] != $lang_id) {
                unset($teasers[$key]);
              }
            }
          //  dd($teasers); //вот тизера которые нужны
            $teasers_update = $this->arrayConcat($teasers_selected, $teasers); //и остальные. слепляем это дело и отдаем данные в страницу редактирования
        }

        $this->crud->addField([
           'label' => "Тизеры",
            'type' => 'select2_from_array_teasers',
            'options' => $teasers_update,
           'name' => 'teasersIds',
           'allows_multiple' => true,
           'attributes' => [
             'data_type' => 'teasers'
           ],
           'wrapperAttributes' => [
             'class' => 'form-group col-md-12 type_data_teasers'
           ]
        ], 'update');
        // $this->crud->addField([ надо добавлять аяксом при выборе языка, тизеры с выбранным языком, для сокращения результатов в селекте. ибо нафига они там все?
        //     'label' => "Тизеры",
        //     'type' => "select2_from_ajax_multiple",
        //     'name' => 'lang_id', // the column that contains the ID of that connected entity
        //     'entity' => 'city', // the method that defines the relationship in your Model
        //     'attribute' => "text", // foreign key attribute that is shown to user
        //     'model' => "App\Models\Teaser", // foreign key model
        //     'data_source' => url("api/cities"), // url to controller search function (with /{id} should return model)
        //     'minimum_input_length' => 2, // minimum characters to type before querying results
        //     'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        // ]);

        $categoryNames = [
          1 => 'Политика',
          2 => 'Экономика',
          3 => 'Гороскопы',
          4 => 'Здоровье',
          5 => 'Шоу-биз',
          6 => 'Знакомства',
          7 => 'Финансы'
        ];

        if (!empty($articles)) {
          $articles_with_categoryNames = $articles;
          foreach ($articles_with_categoryNames as $key => $value) {
            $articles_with_categoryNames[$key][2] = $categoryNames[$articles_with_categoryNames[$key][2]];
          }
        } else $articles_with_categoryNames = [];

        $this->crud->addField([
           'label' => "Новости",
           'type' => 'select2_from_array_articles',
           'options' => $articles_with_categoryNames,
           'name' => 'articlesIds',
           'allows_multiple' => true,
           'attributes' => [
             'data_type' => 'articles'
           ],
           'wrapperAttributes' => [
             'class' => 'form-group col-md-12 type_data_articles'
           ]
        ], 'create');


        if (!empty($articles)) {
          foreach ($articles as $key => $value) {
            $articlesKeys[] = $key;
          }
        }

        $articles_update = [];
        $articles_selected = [];
        $site_id = $this->getSiteIdFromRequestIfExists();
        if ($site_id != null) {
          $country_id = DB::table('sites')
                  ->select('country_id')
                  ->where('id', $site_id)
                  ->get()[0]
                  ->country_id; //id страны редактируемого сайта

            $tmp = DB::table('sites_articles')
            ->select('article_id')
            ->where('site_id', $site_id)
            ->whereIn('article_id', $articlesKeys)->orderBy('num_order')->get();

            foreach ($articles as $key => $value) {
              $articles[$key][2] = $categoryNames[$articles[$key][2]];
            }
            foreach ($tmp as $key => $value) {
              $articles_selected[$value->article_id] = $articles[$value->article_id];
              unset($articles[$value->article_id]);
            }



            foreach($articles as $key => $article) {
              if ($articles[$key][3] != $country_id) {
                unset($articles[$key]);
              }
            }
              //dd($articles);
            $articles_update = $this->arrayConcat($articles_selected, $articles);
        }

        $this->crud->addField([
           'label' => "Новости",
           'type' => 'select2_from_array_articles',
           'options' => $articles_update,
           'name' => 'articlesIds',
           'allows_multiple' => true,
           'attributes' => [
             'data_type' => 'articles'
           ],
           'wrapperAttributes' => [
             'class' => 'form-group col-md-12 type_data_articles'
           ]
        ], 'update');

        $this->crud->addField([
            'name' => 'url1',
            'type' => 'hidden',
            'value' => env('APP_URL')
        ]);
        $this->crud->addField([
            'name' => 'url2',
            'type' => 'hidden',
            'value' => env('APP_URL')
        ]);
        $this->crud->addField([
            'name' => 'url3',
            'type' => 'hidden',
            'value' => env('APP_URL')
        ]);
        $this->crud->addField([
          'name' => 'url4',
          'type' => 'hidden',
          'value' => env('APP_URL')
      ]);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => auth()->user()->id
        ]);

        $this->crud->addClause('where', 'user_id', auth()->user()->id);

    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);
        $langName = DB::table('langs')->where('id', $request->get('lang_id'))->value('name');

        $this->crud->entry->url1 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/preview';
        $this->crud->entry->url2 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/full';
        $this->crud->entry->url3 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/cl';
        $this->crud->entry->url4 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id;
        $this->crud->entry->save();

        // $this->crud->entry->articles()->detach();
        // $this->crud->entry->teasers()->detach();

        $this->crud->entry->articles()->attach($request->get('articlesIds'));
        $this->crud->entry->teasers()->attach($request->get('teasersIds'));

        $count = 1;
        foreach($request->get('teasersIds') as $teaser) {
          $pivot_teaser[$teaser] = ['num_order' => $count];
          $count++;
        }
        foreach($request->get('articlesIds') as $article) {
          $pivot_article[$article] = ['num_order' => $count];
          //$num_order_teaser[$teaser] = $count;
        //  DB::table('teasers')->where('id', $teaser)->update(['num_order_teaser' => $count]);
          $count++;
        }
        //dd($pivot_teaser);
        $this->crud->entry->teasers()->sync($pivot_teaser);
        $this->crud->entry->articles()->sync($pivot_article);

        return $redirect_location;
    }

    protected function getSiteIdFromRequestIfExists()
    {
      if (request()->route()->getName() === 'crud.sites.edit') {
        return intval(request()->route()->parameters['site']);
      }

      return null;
    }

    protected function arrayConcat($arr1, $arr2)
  	{
  	    $result = [];

  	    foreach($arr1 as $key => $value) {
  	        $result[$key] = $value;
  	    }

  	    foreach($arr2 as $key => $value) {
  	        $result[$key] = $value;
  	    }

  	    return $result;
  	}

    public function update(UpdateRequest $request)
    {
        // if ($request->exists('id')) {
        //   $site = Sites::find($request->get('id'));
        //
        //   $site->articles()->detach();
        //   $site->teasers()->detach();
        //
        //   $site->articles()->attach($request->get('articlesIds'));
        //   $site->teasers()->attach($request->get('teasersIds'));
        // }

        $redirect_location = parent::updateCrud($request);
        //dd($this->crud);

        $langName = DB::table('langs')->where('id', $request->get('lang_id'))->value('name');

        $this->crud->entry->url1 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/preview';
        $this->crud->entry->url2 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/full';
        $this->crud->entry->url3 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id.'/cl';
        $this->crud->entry->url4 .= $this->crud->entry->type.'/'.$langName.'/'.$this->crud->entry->id;
        $this->crud->entry->save();

        // $this->crud->entry->articles()->detach();
        // $this->crud->entry->teasers()->detach();

        // $this->crud->entry->articles()->attach($request->get('articlesIds'));
        // $this->crud->entry->teasers()->attach($request->get('teasersIds'));
        $this->crud->entry->articles()->sync($request->get('articlesIds'));
        $this->crud->entry->teasers()->sync($request->get('teasersIds'));
        $count = 1;
        foreach($request->get('teasersIds') as $teaser) {
          $pivot_teaser[$teaser] = ['num_order' => $count];
          $count++;
        }
        foreach($request->get('articlesIds') as $article) {
          $pivot_article[$article] = ['num_order' => $count];
          //$num_order_teaser[$teaser] = $count;
        //  DB::table('teasers')->where('id', $teaser)->update(['num_order_teaser' => $count]);
          $count++;
        }
        //dd($pivot_teaser);
        $this->crud->entry->teasers()->sync($pivot_teaser);
        $this->crud->entry->articles()->sync($pivot_article);

        return $redirect_location;
    }
}
