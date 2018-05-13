<!DOCTYPE html>
<html>

<head>
    <base href="/insidepage/" >
    <script src="http://zozoflex.com/js/script.js" charset="utf-8"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>@if (count($firstArticle) != 0) {{ $firstArticle[0]->name }} @else Everyday hot news  @endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link href="css/css.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link href="css/css_002.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style3.css">
    <script src="/js/dr-dtime.js" charset="utf-8"></script>
    <!-- <script src="files/jquery.js"></script> -->
    <!-- <script async src="/js/f.js"></script> -->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body class="inner-article">
    <header>
        <div class="mob-menu">
            <ul class="ul-nav-bar">
              @foreach($categories as $category)
                @php($routeParams['category'] = $category->slug)
                <li><a class="inherit texts" id="menu{{ $loop->iteration }}" href="{{ route('getcategory', $routeParams) }}">{{ $category->name }}</a></li>
              @endforeach
            </ul>
        </div>
        <div class="first">
            <div class="center-wrapper">
                <div class="status-line clearfix">
                    <div class="time">
                        <ul class="ul-time">
                            <li class="li-timer">
                              <script>
                                (function() {
                                 var now = new Date();
                                 document.write(
                                  (  now.getHours() < 10 ? '0'+now.getHours() : now.getHours() )
                                    +':'+
                                    ( (now.getMinutes()) < 10 ? '0'+(now.getMinutes()) : (now.getMinutes()) )
                                 );
                                }())
                              </script>
                            </li>
                            <li class="day-to"><script> dtime_nums(-1, true);</script></li>
                            <li class="day-to">
                              @if (count($country) != 0) <img src="/img/flags/{{ $country[0]->fullname }}.png" alt=""> @endif
                            </li>
                        </ul>
                    </div>
                    <div class="news">
                       <!--  <p class="news-p"><span class="bold-span">Fresh news: &nbsp;</span><a class="data-block inherit" href="" target="_blank"  data-type="news" data-id="133">Кремль подтвердил официально! Путин женился! Избранницей стала..</a></p> -->
                    </div>
                    <!-- <div class="soc">
                        <ul class="ul-soc">
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <div class="clear"></div>
                        </ul>
                    </div> -->
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="second">
            <div class="center-wrapper">
                <div class="basic-line clearfix">
                    <div class="logo-header"><img class="logotype" src="/img/logo-head.png" ></div>
                    <div class="menubar">
                      <i id="open_menu" class="fa fa-bars"></i>
                      <i id="close_menu" class="fa fa-times"></i>
                    </div>
                    <div class="menu-bar">
                        <ul class="ul-nav-bar">
                          @foreach($categories as $category)
                            @php($routeParams['category'] = $category->slug)
                            <li><a class="inherit texts" id="menu{{ $loop->iteration }}" href="{{ route('getcategory', $routeParams) }}">{{ $category->name }}</a></li>
                          @endforeach
                        </ul>
                    </div>
                    <div class="search-bar">
                        <form class="search-form">
                            <input class="search-input" type="search">
                            <a class="search-button" ></a>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </header>
    <section class="top-line">
        <div class="center-wrapper">
            <div class="content">
                <div class="headline texts" id="hot_news">Горячие новости</div>
                @if ($siteType == 'cl') <div class="news-block" id="topline"> @else <div class="news-block news-block-google" id="topline"> @endif
                  @if ($siteType != 'cl')
                    @foreach($teasersTop3 as $teaser)
                      @if ($loop->iteration == 3)
                      <a class="preview data-block" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers">
                          <div class="image">
                            @if ($teaser->gif)
                              <img class="picture__small" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                            @else
                              <img class="picture__small" src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                            @endif
                          </div>
                          <div class="title google_sense2">
                            <div class="cbb">
                              <svg fill="#00aecd" height="15" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                  <path d="M0 0h24v24H0z" fill="none"/>
                              </svg>
                            </div>
                            <div class="abgb" title="Google">
                              <svg fill="#00aecd" height="15" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M0 0h24v24H0z" fill="none"/>
                                  <path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/>
                              </svg>
                            </div>
                            <div class="bygoogle">Google</div>
                            {{ $teaser->text }}
                            <div class="g_button">
                              <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
                                  <path d="M0-.25h24v24H0z" fill="none"/>
                              </svg>
                            </div>
                          </div>
                      </a>
                      @else
                        <a class="preview data-block relativeA" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers">
                            <div class="image">
                              @if ($teaser->gif)
                                <img class="picture__small" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                              @else
                                <img class="picture__small" src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                              @endif
                            </div>
                            <div class="title google_sense2">{{ $teaser->text }}
                              <div class="g_button">
                                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
                                    <path d="M0-.25h24v24H0z" fill="none"/>
                                </svg>
                              </div>
                            </div>

                        </a>
                      @endif
                    @endforeach
                  @else
                    @for ($i = 0; $i < 3; $i++)
                          <ins class="adsbygoogle preview"
                               data-ad-client="ca-pub-2277248116838761"
                               data-ad-slot="9927249008"></ins>
                          <script>
                          (adsbygoogle = window.adsbygoogle || []).push({});
                          </script>
                    @endfor
                  @endif
                </div>
            </div>
        </div>
    </section>
    <section class="high-priority-news">
        <div class="center-wrapper">
            <div class="content clearfix">
                <div class="column latest" id="article_content">
                    <div class="article wo-headline" id="article" data-id="2109" data-category="12">
                      @if (count($firstArticle) != 0)
                        <div class="image"><img alt="{{ $firstArticle[0]->name }}" src="/{{ $firstArticle[0]->image }}">
                            <div class="added-info">
                                <div class="category">{{ $categoryNow }}</div>
                                <div class="date"><script> dtime_nums(-1, true);</script></div>
                            </div>
                        </div>
                        <div class="title">
                            <h1 class="h1-inherit">{{ $firstArticle[0]->name }}</h1>
                        </div>
                        <div class="text" style="color: rgb(51, 51, 51); font-family: TabacSans, Arial; font-size: 20px;">
                          {!! $firstArticle[0]->text !!}
                          <div class="hidden" id="link">{{ $link }}</div>
                          <div class="hidden" id="context_name"> {{ $firstArticle[0]->context_name }}</div>
                          <div class="hidden" id="context_description">{{ $firstArticle[0]->context_description }}</div>

                        </div>
                        <div class="topic-panel clearfix">
                            <div class="views"><i class="fa fa-eye"></i> 2113364</div>
                        </div>
                      @else
                        <p>Новостей пока нет</p>
                      @endif
                    </div>
             <!--        <div class="more-news">
                        <div class="caption">in theme:</div>
                        <ul class="news-list">
                            <li class="data-block" data-type="news" data-id="2113"><a href="">ОЛЬГА БУЗОВА УМЕРЛА ОТ УГАРНОГО ГАЗА - ПОДРОБНОСТИ ТРАГЕДИИ...</a></li>
                            <li class="data-block" data-type="news" data-id="1369"><a href="">Новая жена президента сразила всех наповал. Это известная...</a></li>
                            <li class="data-block" data-type="news" data-id="2088"><a href="">Леонид Якубович умер, скорбим.</a></li>
                        </ul>
                    </div> -->
                </div>
                <div class="column important" id="center">
                    <div class="headline texts" id="important">Важно знать</div>
                    @foreach($articles as $article )
                    @php($routeParams['category'] = $article->slug)
                    @php($routeParams['article'] = $article->id)
                      <a class="preview data-block" href="{{ route('getarticle', $routeParams) }}" target="_blank"  data-type="news">
                          <div class="image">
                            <img alt="image" src="/{{ $article->image }}">
                            <div class="added-info">
                                <div class="category">{{ $categoryNow }}</div>
                                <div class="date"><script> dtime_nums(-1, true);</script></div>
                            </div>
                          </div>
                          <div class="title">{{ $article->name }}</div>
                      </a>
                    @endforeach
            </div>
            <div class="column popular" id="right">
                <div class="headline texts" id="popular">Популярное сегодня</div>
                @if ($siteType != 'cl')
                @foreach($teasersRight4 as $teaser)
                  @if ( ( $type_links == 'pop' && $loop->iteration > 2 && $iteration1 = 3)
                    || ( $type_links == 'native' && $loop->iteration > 3 && $iteration1 = 4))
                    @if ($iteration1 == $loop->iteration) <div class="right-block-google">  @endif
                    <a class="preview data-block google_sense" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers" style="margin-bottom: 7px">
                        <div class="image" >
                          @if ($teaser->gif)
                            <img src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                          @else
                            <img src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                          @endif
                        </div>
                        <div class="title google_sense2" >
                          @if ($iteration1 == $loop->iteration)
                          <div class="cbb">
                            <svg fill="#00aecd" height="15" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                <path d="M0 0h24v24H0z" fill="none"/>
                            </svg>
                          </div>
                          <div class="abgb" title="Google">
                            <svg fill="#00aecd" height="15" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/>
                            </svg>
                          </div>
                          <div class="bygoogle">Google</div>
                          @endif
                          {{ $teaser->text }}
                          <div class="g_button">
                            <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
                                <path d="M0-.25h24v24H0z" fill="none"/>
                            </svg>
                          </div>
                        </div>
                    </a>
                    @if ($loop->iteration == 6 && $type_links == 'native' || $loop->iteration == 5 && $type_links == 'pop') </div>  @endif
                  @else
                    <a class="preview data-block" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers">
                        <div class="image">
                          @if ($teaser->gif)
                            <img src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                          @else
                            <img src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                          @endif
                        </div>
                        <div class="title">{{ $teaser->text }}</div>
                    </a>
                  @endif
                @endforeach
                @else
                  @for ($i = 0; $i < 7; $i++)
                      <ins class="adsbygoogle preview"
                           data-ad-client="ca-pub-2277248116838761"
                           data-ad-slot="9927249008"></ins>
                      <script>
                      (adsbygoogle = window.adsbygoogle || []).push({});
                      </script>
                  @endfor
                @endif
                <!-- <a class="preview data-block" href="" target="_blank"  data-type="adsense2" data-id="498">
                    <div class="title">
                      <ins class="adsbygoogle"
                           style="display:-block;width:470px;height:70px"
                           data-ad-client="ca-pub-2277248116838761"
                           data-ad-slot="9927249008"></ins>
                      <script>
                      (adsbygoogle = window.adsbygoogle || []).push({});
                      </script>
                    </div>
                </a> -->

            </div>
        </div>
        </div>
    </section>
    <section class="category-preview alternative" data-id="0">
        <div class="center-wrapper">
            <div class="content">
                <div class="headline texts" id="recommed">Рекоммендации</div>
                <div class="news-container clearfix">
                @if ($siteType != 'cl')
                  @foreach($teasersRecommend as $teaser)
                    <a class="preview other-news data-block top1" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers">
                        <div class="image">
                          @if ($teaser->gif)
                            <img src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                          @else
                            <img src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                          @endif
                        </div>
                        <div class="title">{{ $teaser->text }}</div>
                    </a>
                  @endforeach
                  @else
                  @for ($i = 0; $i < 5; $i++)
                      <ins class="adsbygoogle preview other-news top1"
                           data-ad-client="ca-pub-2277248116838761"
                           data-ad-slot="9927249008"></ins>
                      <script>
                      (adsbygoogle = window.adsbygoogle || []).push({});
                      </script>
                    @endfor
                  @endif
                </div>
            </div>
        </div>
    </section>
    <section class="category-preview alternative" data-id="1">
        <div class="center-wrapper">
            <div class="content">
                <div class="headline texts" id="actual">Актуальное</div>
                <div class="news-container clearfix">
                  @if ($siteType != 'cl')
                    @foreach($teasersActual as $teaser)
                      <a class="preview other-news data-block" href="{{ $link }}{{ $teaser->num_order }}" target="_blank"  data-type="teasers">
                          <div class="image">
                            @if ($teaser->gif)
                              <img src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                            @else
                              <img src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                            @endif
                          </div>
                          <div class="title">{{ $teaser->text }}</div>
                      </a>
                    @endforeach
                  @else
                  @for ($i = 0; $i < 5; $i++)
                          <ins class="adsbygoogle preview other-news"
                               data-ad-client="ca-pub-2277248116838761"
                               data-ad-slot="9927249008"></ins>
                          <script>
                          (adsbygoogle = window.adsbygoogle || []).push({});
                          </script>
                    @endfor
                  @endif

                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="center-wrapper">
            <div class="content">
                <div class="left-part-footer"><a href=""><img class="footer-logo" src="/img/logo-head.png" alt="fresh-news.eversmi.com"></a></div>
                <div class="right-part-footer">
                    <div class="soc-footer">
                        <!-- <ul class="ul-soc-footer">
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <div class="clear"></div>
                        </ul> -->
                    </div>
                </div>
                <div class="breadcrumbs very-important">
                </div>
                <div class="clear"></div>
                <p class="footer-txt">Copyright © 2018 World'SMI. All rights reserved<span class="bl">For children over 16 years old.</span></p>
            </div>
        </div>
    </footer>
    <div id="addjs"> {{ $addjs }} </div>
    <script src="/js/jquery-1.12.4.min.js" charset="utf-8"></script>
    <!-- <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=en-US" type="text/javascript"></script> -->
    <!-- <script src="/js/sticky-sidebar.js" charset="utf-8"></script> -->

    <script type="text/javascript">
      $(document).ready(function() {
        if ($('#addjs').text() == 1) {
            var script=document.createElement('script');
            script.src='/js/push.js';
            document.getElementsByTagName('body')[0].appendChild(script);
        }
        if ($(window).width() >= 1184) {
          // var sidebar = new StickySidebar('#right', {
          //   topSpacing: 20,
          //   bottomSpacing: 20
          // });
          $('#right').css({
            'position': 'sticky',
            'top': '2px',
            'height': $(window).height()+100,
          });
          $('#center').css({
            'position': 'sticky',
            'top': '2px',
            'height': $(window).height()+100,
          });
        } else {
          $('#right').css({
            'position': 'inherit',
            'top': '',
            'height': 'auto',
          });
          // if ($(window).width() >= 640) {
          //   var sidebar = new StickySidebar('#center', {
          //     containerSelector: '#article_content',
          //     topSpacing: 20,
          //     bottomSpacing: 20
          //   });
          // }
        }

        $('p').each(function(i, elem) {
          if ($(elem).text() == '[context]') {
          $(elem).text('');
          $(elem).append(`<div id="context">
                    <a href="${$('#link').text()}20"><h1>${$('#context_name').text()}</h1></a>
                    <a href="{{ $link }}20"><p>${$('#context_description').text()}</p><a href="{{ $link }}/20">
                    <div class="abgb" title="Google">
                      <svg fill="#00aecd" height="15" viewBox="0 0 24 24" width="15" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0 0h24v24H0z" fill="none"/>
                          <path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/>
                      </svg>
                    </div>
                    <a href="{{ $link }}20">
                      <div class="g_button">
                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
                            <path d="M0-.25h24v24H0z" fill="none"/>
                        </svg>
                      </div>
                    </a>
                    <div class="bygoogle">Google</div>
                    </context>`)
          }
        })
        var clickMenu = 0;
        $('.menubar').on('click', function() {
          if (clickMenu % 2 === 0) {
            $('#open_menu').fadeOut(200, function() {
              $('#close_menu').fadeIn(200);
            })
          } else {
            $('#close_menu').fadeOut(200, function() {
              $('#open_menu').fadeIn(200);
            })
          }
          $('.mob-menu').slideToggle();
          clickMenu++;
        })

      })
    </script>
    <script src="/js/lang.js" charset="utf-8"></script>
</body>

</html>
