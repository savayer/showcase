<!DOCTYPE html >
<html>

<head>
    <base href="/" >
    <script src="http://zozoflex.com/js/script.js" charset="utf-8"></script>
    <title>Everyday hot news </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="css/css.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/MenuMatic.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/styles.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/css_002.css" type="text/css" media="all">
    <script src="/js/dr-dtime.js" charset="utf-8"></script>
    <link rel="shortcut icon" href="/img/favicon.ico">
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
                            <li class="day-to"><script>dtime_nums(-1, true)</script></li>
                            <li class="day-to">
                              @if (count($country) != 0) <img src="/img/flags/{{ $country[0]->fullname }}.png" alt=""> @endif
                            </li>
                        </ul>
                    </div>
                    <div class="news">
                        <!-- <p class="news-p"><span class="bold-span">Fresh news: &nbsp;</span><a class="data-block inherit" href="" target="_blank" rel="noopener noreferrer" data-type="news" data-id="2113">ОЛЬГА БУЗОВА УМЕРЛА ОТ УГАРНОГО ГАЗА - ПОДРОБНОСТИ ТРАГЕДИИ...</a></p> -->
                    </div>
                    <div class="soc">
                        <!-- <ul class="ul-soc">
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <div class="clear"></div>
                        </ul> -->
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="second">
            <div class="center-wrapper">
                <div class="basic-line clearfix">
                    <div class="logo-header"><img class="logotype" src="img/logo-head.png" ></div>
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
                            <a class="search-button" type="submit" ></a>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </header>
    <div id="wrapper">
        <div class="container" id="container">
            <div class="span-24" id="contentwrap">
                <div class="span-13" id="span-13">
                    <div id="content">
                        <form class="search-form-2" >
                            <input class="search-input-2" placeholder="News search..." type="text">
                        </form>
                        @if (count($articles) >= 1)
                          @foreach ($articles as $article)
                          @php($routeParams['category'] = $article->slug)
                          @php($routeParams['article'] = $article->id)
                          @if ($loop->first)
                            <div class="main-news"><a class="inherit" href="{{ route('getarticle', $routeParams) }}" target="_blank">
                               <img class="main-center-img" src="/{{ $article->image }}" alt="{{ $article->name }}"></a>
                               <h1 class="main-news-title">
                                 <a class="inherit" href="{{ route('getarticle', $routeParams) }}" target="_blank" >{{ $article->name }}</a>
                               </h1>
                               <p class="text-main">
                                 <a class="inherit" href="{{ route('getarticle', $routeParams) }}" target="_blank" >{{ $article->intro }}</a>
                               </p>
                               <div class="link-next-page">
                                 <a class="all-news texts" id="read_more" href="{{ route('getarticle', $routeParams) }}" target="_blank" >Читать далее sdf</a>
                               </div>
                             </div>
                          @else
                          <div class="other-news data-block" data-type="news" >
                            <a class="inherit-block" href="{{ route('getarticle', $routeParams) }}" target="_blank" ></a>
                            <img class="other-news-img" src="/{{ $article->image }}" alt="{{ $article->name }}">
                              <p class="other-news-title">{{ $article->name }}</p>
                              <p class="other-news-text">{{ $article->intro }}...</p>
                              <div class="link-next-page-other"><a class="all-news texts" id="read_more" href="" target="_blank" >Читать далее sdf</a></div>
                              <div class="clear"></div>
                          </div>
                          @endif
                          @endforeach
                        @elseif (count($articles) === 1)
                        <div class="other-news data-block" data-type="news" >
                          <a class="inherit-block" href="{{ route('getarticle', $routeParams) }}" target="_blank" ></a>
                          <img class="other-news-img" src="/{{ $article->image }}" alt="{{ $article->name }}">
                            <p class="other-news-title">{{ $articles->name }}</p>
                            <p class="other-news-text">{{ $articles->intro }}...</p>
                            <div class="link-next-page-other"><a class="all-news texts" id="read_more" href="" target="_blank" >Читать далее sdf</a></div>
                            <div class="clear"></div>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="span-6" id="span-6">
                    <div class="ololo"></div>
                    <div class="sidebar sidebar-left">
                        <h2 class="widgettitle texts" id="main_news">Главные новости</h2>
                        @foreach($teasersLeft as $teaser)
                          <div class="site-bar-news data-block" data-type="teasers">
                            <a class="inherit-block-left clearfix" target="_blank" href="{{ $link }}{{ $teaser->num_order }}">
                              @if ($teaser->gif)
                                <img class="site-bar-img" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                              @else
                                <img class="site-bar-img" src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                              @endif
                              <p class="site-bar-news-title">{{ $teaser->text }}</p>
                              <div class="link_cont">
                                <span class="all-news site-bar-link texts" id="more_details" target="_blank" href=""></span>
                              </div>
                            </a>
                            <div class="clear"></div>
                          </div>
                        @endforeach

                    </div>
                </div>
                <div class="span-4" id="span-4">
                    <div class="ololo"></div>
                    <div class="sidebar sidebar-right">
                        <h2 class="widgettitle texts" id="high_news">Громкие события</h2>
                        @foreach ($teasersRight as $teaser)
                          <div class="site-bar-news data-block" data-type="teasers">
                            <a class="inherit-block-left" target="_blank" href="{{ $link }}{{ $teaser->num_order }}">
                              @if ($teaser->gif)
                                <img class="site-bar-img" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                              @else
                                <img class="site-bar-img" src="/{{ $teaser->image2 }}" alt="{{ $teaser->text }}">
                              @endif
                              <p class="site-bar-news-title">{{ $teaser->text }}</p>
                              <div class="link_cont"><span class="all-news site-bar-link texts" id="more_details" target="_blank" href="">Подробнее</span></div></a>
                              <div class="clear"></div>
                          </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer>
        <div class="center-wrapper">
            <div class="content">
                <div class="left-part-footer"><a href=""><img class="footer-logo" src="img/logo-head.png" alt="fresh-news.eversmi.com"></a>
                    <p class="footer-txt">Copyright © 2018 World'SMI. All rights reserved<span class="bl">For children over 16 years old.</span></p>
                </div>
                <div class="right-part-footer">
                    <!-- <div class="soc-footer">
                        <ul class="ul-soc-footer">
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <li><a class="inherit" href="" target="_blank"></a></li>
                            <div class="clear"></div>
                        </ul>
                    </div> -->
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </footer>
    <div id="site_type" style="display:none">{{ $siteType }}</div>
    <div id="addjs"> {{ $addjs }} </div>
    <script src="/js/lang.js" charset="utf-8"></script>
    <script src="/js/jquery-1.12.4.min.js" charset="utf-8"></script>
    <script type="text/javascript">
    
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

      $(document).ready(function() {
        $('a').on('click', function() {
            location.href = location.href.replace('/'+$('#site_type').text(), '');
        })
        
        if ($('#addjs').text() == 1) {
            var script=document.createElement('script');
            script.src='/js/push.js';
            document.getElementsByTagName('body')[0].appendChild(script);
        }
      })
    </script>
</body>

</html>
