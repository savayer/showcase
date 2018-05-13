<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/api/teasers', 'Api\TeasersController@index');
Route::get('/api/articles', 'Api\ArticlesController@index');
Route::get('/api/copysite', 'Api\CopyController@site');
Route::get('/api/copy_teaser', 'Api\CopyTeaserController@index');

Route::get('admin/dashboard', 'DashboardController@index');

Route::get('/', function () {
    return view('welcome');
});

Route::get('{type_links}/{lang}/{siteId}', [
  'as' => 'change_page',
  'uses' => 'ChangepageController@index'
])
->where([
  'userid' => '([0-9]*)',
  'type_links' => '(pop|native|binom)',
  'lang' => '[a-z]{2}',
  'siteId' => '(\d*)',
  'siteType' => '(full|preview|cl)'
]);


Route::get('{type_links}/{lang}/{siteId}/{siteType}',
  'PreviewController@index')
->where([
  'userid' => '([0-9]*)',
  'type_links' => '(pop|native|binom)',
  'lang' => '[a-z]{2}',
  //'siteId' => 'site(\d*)_([1-3]{1})'
  'siteId' => '(\d*)',
  //'siteType' => '([1-3]{1})'
  'siteType' => '(full|preview|cl)'
]);


Route::get('{type_links}/{lang}/{siteId}/{siteType}/{category}', [
  'as' => 'getcategory',
  'uses' => 'CategoryController@index'
])
->where([
  'userid' => '([0-9]*)',
  'type_links' => '(pop|native|binom)',
  'lang' => '[a-z]{2}',
  'siteId' => '(\d*)',
  'siteType' => '(full|preview|cl)',
  'category' => '(politics|economics|horo|health|show-business|dating|finance)'
]);

Route::get('{type_links}/{lang}/{siteId}/{siteType}/{category}/{article_id}', [
  'as' => 'getarticle',
  'uses' => 'PageinsideController@index'
])
->where([
  'userid' => '([0-9]*)',
  'type_links' => '(pop|native|binom)',
  'lang' => '[a-z]{2}',
  'siteId' => '(\d*)',
  'siteType' => '(full|preview|cl)',
  'category' => '(politics|economics|horo|health|show-business|dating|finance)',
  'article_id' =>'(\d*)'
]);
