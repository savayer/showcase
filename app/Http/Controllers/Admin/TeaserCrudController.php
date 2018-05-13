<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\DB;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TeaserRequest as StoreRequest;
use App\Http\Requests\TeaserRequest as UpdateRequest;
use App\Models\Teaser;
use App\Models\Lang;
use App\Models\Country;

class TeaserCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Teaser');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/teaser');
        $this->crud->setEntityNameStrings('teaser', 'teasers');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // $this->crud->allowAccess('reorder');
        // $this->crud->enableReorder('text', 1);
        //$this->crud->setFromDb();
        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Изображение',
            'type' => 'image_custom'
        ]);
        $this->crud->addColumn([
            'name' => 'text',
            'label' => 'Описание',
            'type' => 'text',
            'limit' => '50'
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
           'name' => 'lang_id',
           'type' => "select",
           'entity' => 'lang',
           'attribute' => "fullname",
           'model' => "App\Models\Lang"
        ]);

        $this->crud->addColumn([
           'name' => 'gif', // The db column name
           'label' => "gif", // Table column heading
           'type' => 'check'
        ]);

        $this->crud->addButton('line', 'copy', 'view', 'crud::buttons.copy_teaser', 'end');

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

        //FIELDS
        $this->crud->addField([
            'name' => 'gif',
            'label' => 'Загружать GIF',
            'type' => 'checkbox_custom'
        ]);
        $this->crud->addField([
            'label' => "Изображение тизера",
            'name' => "image",
            'type' => 'teaser_image1',
            'upload' => true,
            'crop' => true,
            'wrapperAttributes' => [
               'class' => 'form-group image teaset_image1 col-md-12'
             ],
        ]);

        $this->crud->addField([
            'label' => "Изображение кв.",
            'name' => "image2",
            'type' => 'teaser_image2',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            'wrapperAttributes' => [
               'class' => 'form-group image teaser_image2 col-md-12'
             ],
        ]);

        $this->crud->addField(
          [   // Upload
              'name' => 'image1gif',
              'label' => 'GIF Изображение',
              'type' => 'upload2',
              'upload' => true,
              'disk' => 'uploads',
              'wrapperAttributes' => [
                 'class' => 'form-group gif_image1 col-md-12'
               ],
          ]);

        // $this->crud->addField(
        //   [   // Upload
        //       'name' => 'image2gif',
        //       'label' => 'GIF Изображение 2',
        //       'type' => 'upload2',
        //       'upload' => true,
        //       'disk' => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        //       'wrapperAttributes' => [
        //          'class' => 'form-group gif_image2 col-md-12'
        //        ],
        //   ]);

        $this->crud->addField([
          'name' => 'text',
          'label' => 'Содержание',
          'type' => 'textarea_teaser'
        ]);

        //dd($this);
/*

не работает считывание установленного языка и страны, посему сделано несколько по другому. Ниже
        // $this->crud->addField([
        //    'label' => "Страна",
        //    'type' => 'select2',
        //    'name' => 'country_id', // the db column for the foreign key
        //    'entity' => 'country', // the method that defines the relationship in your Model
        //    'attribute' => 'name', // foreign key attribute that is shown to user
        //    'model' => "App\Models\Country" // foreign key model
        // ]);

        // $this->crud->addField([
        //    'label' => "Язык",
        //    'name' => 'lang_id',
        //    'type' => 'select2',
        //    'entity' => 'lang', // the method that defines the relationship in your Model
        //    'attribute' => 'fullname', // foreign key attribute that is shown to user
        //    'model' => "App\Models\Lang" // foreign key model
        // ]);

        */
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

        /*dd(auth()->user()->id);*/
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
