<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Lang;
use App\Models\Country;

class ArticleCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // $countries = Article::getUniqueCountryIds();
        // $countries2 = Country::select('id')->get();
//        $countries = DB::table('countries')->select('id', 'name')->get();
        //$countries = DB::table('countries')->pluck('name');
        // $countries = (array) $countries;
    // $i = 1;
    // foreach ($countries as $country) {
    //   $new_country[$i] = $country->name;
    //   $i++;
    // }
    //
    // echo "<pre>";
    // print_r($new_country);
    // die();

        //$this->crud->setFromDb();
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
            'limit' => '30'
        ]);
        $this->crud->addColumn([
            'name' => 'intro',
            'label' => 'Превью',
            'type' => 'text',
            'limit' => '40'
        ]);
        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Изображение',
            'type' => 'image'
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
           'label' => "Категория",
           'name' => 'category_id',
           'type' => "select",
           'entity' => 'category',
           'attribute' => "name",
           'model' => "App\Models\Article"
        ]);

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
          // $arr = array(
          //   169 => 'Россия',
          //   197 => 'Таиланд'
          // );
          // $countryIds = Article::getUniqueCountryIds();
          // echo "<pre>";
          // die(print_r($countryIds));
          // return $arr;

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

        $this->crud->addFilter([ // add a "simple" filter called Draft
          'type' => 'select2',
          'name' => 'category_id',
          'label'=> 'По категории'
        ],
        function() {
          $categories = DB::table('categories')->select('id', 'name')->get();
          $i = 1;
          foreach ($categories as $category) {
            $new_categories[$i] = $category->name;
            $i++;
          }
          return $new_categories;
        },
        function($value) {
          $this->crud->addClause('where', 'category_id', $value);
        });

        // FIELDS
        $categories = Category::getCategoryForCrudIOptions();
        $this->crud->addField([
           'label' => "Категория",
           'type' => 'select2_from_array',
           'options' => $categories,
           'name' => 'category_id',
           'allows_multiple' => false
        ], 'both');

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Название новости',
            'attributes' => [
               'class' => 'form-control',
               'maxlength' => '255'
             ]
        ]);

        $this->crud->addField([
            'name' => 'intro',
            'label' => 'Превью',
            'attributes' => [
               'class' => 'form-control',
               'maxlength' => '255'
             ]
        ]);

        // $this->crud->addField([
        //     'name' => 'image',
        //     'label' => 'Изображение новости',
        //     'type' => 'browse'
        // ]);
        $this->crud->addField([
            'label' => "Изображение новости",
            'name' => "image",
            'type' => 'teaser_image1',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'wrapperAttributes' => [
               'class' => 'form-group image teaset_image1 col-md-12'
             ],
        ]);

        $countries = Country::getCountriesForCrudIOptions();
        $this->crud->addField([
           'label' => "Страна",
           'type' => 'select2_from_array',
           'options' => $countries,
           'name' => 'country_id',
           'allows_multiple' => false
        ], 'both');

        $langs = Lang::getLangsForCrudIOptions();
        $this->crud->addField([
           'label' => "Язык",
           'type' => 'select2_from_array',
           'options' => $langs,
           'name' => 'lang_id',
           'allows_multiple' => false
        ], 'both');

        $this->crud->addField([
          'name' => 'context_name',
          'label' => 'Название контекста',
          'type' => 'text',
          'attributes' => [
             'placeholder' => 'Название контекстной рекламы которую ты вставишь тегом в редактор.',
             'class' => 'form-control some-class',
             'maxlength' => '50'
           ]
        ]);

        $this->crud->addField([
          'name' => 'context_description',
          'label' => 'Описание контекста',
          'type' => 'textarea',
          'attributes' => [
             'placeholder' => 'Описание контекстной рекламы которую ты вставишь тегом в редактор.',
             'class' => 'form-control some-class',
             'maxlength' => '80'
           ]
        ]);

        $this->crud->addField([
          'name' => 'text',
          'label' => 'Содержание. Для вставки контекста пропишите - [context]',
          'type' => 'ckeditor'
        ]);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => auth()->user()->id
        ]);

        $this->crud->addClause('where', 'user_id', auth()->user()->id);

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
