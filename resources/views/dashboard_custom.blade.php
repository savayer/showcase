@extends('backpack::layout')

@section('header')
<!-- ========================================================================================================= -->
<!-- ========================================================================================================= -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var s = {!! json_encode($sites) !!},
            t = {!! json_encode($teasers) !!},
            a = {!! json_encode($articles) !!},
            chartCountry = {!! json_encode( $chartCountry ) !!},

            chartArticles = {!! json_encode( $chartArticles ) !!},
            chartTeasers = {!! json_encode( $chartTeasers ) !!},
            chartArticleCategory = {!! json_encode( $chartArticleCategory ) !!};

        var dataTmp = [
          ['Task', 'Sites By Country'],
        ]
        for (var key in chartCountry) {
          dataTmp.push( [key, chartCountry[key]] );
        }

        var articlesByCategoryData = google.visualization.arrayToDataTable(dataTmp),
            options = {
              title: 'Сайты по странам'
            },
            chartSites = new google.visualization.PieChart(document.getElementById('sites'));

        chartSites.draw(articlesByCategoryData, options);


        /*
        *
        * POP
        *
        */
        // var dataTmp = [
        //   ['Task', 'Sites POP By Country '],
        // ]
        // for (var key in chartCountryPop) {
        //   dataTmp.push( [key, chartCountryPop[key]] );
        // }
        //
        // var chartPopData = google.visualization.arrayToDataTable(dataTmp),
        //     options = {
        //       title: 'POP сайты по странам'
        //     },
        //     chartPop = new google.visualization.PieChart(document.getElementById('chartPop'));
        //
        // chartPop.draw(chartPopData, options);

        /*
        *
        * Native
        *
        */
        // var dataTmp = [
        //   ['Task', 'Sites POP By Country '],
        // ]
        // for (var key in chartCountryNative) {
        //   dataTmp.push( [key, chartCountryNative[key]] );
        // }
        //
        // var chartCountryNativeData = google.visualization.arrayToDataTable(dataTmp),
        //     options = {
        //       title: 'POP сайты по странам'
        //     },
        //     chartNative = new google.visualization.PieChart(document.getElementById('chartNative'));
        //
        // chartNative.draw(chartCountryNativeData, options);


        /*
        *
        * Binom
        *
        */
        // var dataTmp = [
        //   ['Task', 'Sites POP By Country '],
        // ]
        // for (var key in chartCountryBinom) {
        //   dataTmp.push( [key, chartCountryBinom[key]] );
        // }
        //
        // var chartBinomData = google.visualization.arrayToDataTable(dataTmp),
        //     options = {
        //       title: 'POP сайты по странам'
        //     },
        //     chartBinom = new google.visualization.PieChart(document.getElementById('chartBinom'));
        //
        // chartBinom.draw(chartBinomData, options);
        /************************************************************************************************/
        /******************************teasers******************************************************************/

        var dataTmp = [
          ['Task', 'Teasers By Country'],
        ]
        for (var key in chartTeasers) {
          dataTmp.push( [key, chartTeasers[key]] );
        }

        var teasersByCountryData = google.visualization.arrayToDataTable(dataTmp),
            options = {
              title: 'Тизеры по странам'
            },
            teasersByCountry = new google.visualization.PieChart(document.getElementById('teasersByCountry'));

        teasersByCountry.draw(teasersByCountryData, options);

        /************************************************************************************************/
        /*********************************articles***************************************************************/
        var dataTmp = [
          ['Task', 'Articles By Country'],
        ]
        for (var key in chartArticles) {
          dataTmp.push( [key, chartArticles[key]] );
        }

        var articlesByCountryData = google.visualization.arrayToDataTable(dataTmp),
            options = {
              title: 'Новости по странам'
            },
            articlesByCountry = new google.visualization.PieChart(document.getElementById('articlesByCountry'));

        articlesByCountry.draw(articlesByCountryData, options);


        var dataTmp = [
          ['Task', 'Articles By Category'],
        ]
        for (var key in chartArticleCategory) {
          dataTmp.push( [key, chartArticleCategory[key]] );
        }

        var articlesByCategoryData = google.visualization.arrayToDataTable(dataTmp),
            options = {
              title: 'Новости по категориям'
            },
            articlesByCategory = new google.visualization.PieChart(document.getElementById('articlesByCategory'));

        articlesByCategory.draw(articlesByCategoryData, options);

        /************************************************************************************************/
        /************************************************************************************************/
      }
    </script>
<!-- ========================================================================================================= -->
<!-- ========================================================================================================= -->
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }} ( {{ auth()->user()->name }} )
        <!-- <small>{{ trans('backpack::base.first_page_you_see') }}</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Сайтов: <b>{{ $sites }}</b></div>
                </div>
                <div class="box-body" style="height: 550px">
                  <div id="sites" style=" height: 500px;"></div>
                  <!-- <ul class="nav nav-tabs" id="navs">
                    <li class="active">
                      <a href="#general" data-toggle="tab">Общий</a>
                    </li>
                    <li >
                      <a href="#pop" data-toggle="tab">POP</a>
                    </li>
                    <li >
                      <a href="#native" data-toggle="tab">Native</a>
                    </li>
                    <li >
                      <a href="#binom" data-toggle="tab">Binom RU</a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div id="general" class="tab-pane fade in active">
                      <div id="sites" style=" height: 500px;"></div>
                    </div>
                    <div id="pop" class="tab-pane fade">
                      <div id="chartPop" style="width: 500px; height: 400px"></div>
                    </div>
                    <div id="native" class="tab-pane fade">
                      <div id="chartNative" ></div>
                    </div>
                    <div id="binom" class="tab-pane fade">
                      <div id="chartBinom"></div>
                    </div>
                  </div> -->
                </div>
            </div>
        </div>

        <div class="col-sm-6">
          <div class="box box-default">
              <div class="box-header with-border">
                  <div class="box-title">Тизеров: <b>{{ $teasers }}</b></div>
              </div>

              <div class="box-body">
                  <div id="teasersByCountry" style="height: 500px;"></div>
              </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="box box-default">
              <div class="box-header with-border">
                  <div class="box-title">Новостей: <b>{{ $articles }}</b></div>
              </div>
              <div class="box-body" style="display: flex; justify-content: space-between">
                <div id="articlesByCountry" style="width: 600px; height: 500px;"></div>
                <div id="articlesByCategory" style="width: 600px; height: 500px;"></div>
              </div>
          </div>
        </div>
    </div>
@endsection
