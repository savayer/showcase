<!DOCTYPE html>
<html>

<head>
  <base href="/change/">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title class="texts" id="advises"></title>
    <link rel="stylesheet" href="files/normalize.css">
    <link rel="stylesheet" href="files/style.css">
    <link rel="stylesheet" href="files/font-awesome.css">
    <link href="files/css.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="/img/favicon.ico">
</head>

<body>
    <div class="above-teasers">
        <p id="popular" class="texts"></p>
    </div>
    <div class="teaser-field wookmark-initialised" style="display: block; height: 4894px;">
      @foreach ($teasers as $teaser)
        <div class="teaser data-block" data-type="teasers" data-wookmark-id="0" data-wookmark-height="379" data-wookmark-top="0" style="position: absolute; top: 0px; left:50px;">
            <a href="{{ $link }}{{ $teaser->num_order }}" target="_blank" >
                <div class="teaser-image-div">
                  @if ($teaser->gif)
                    <img class="teaser-image" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                  @else
                    <img class="teaser-image" alt="{{ $teaser->text }}" src="/{{ $teaser->image2 }}">
                  @endif
                </div>
                <div class="teaser-title-div">
                    <p class="teaser-title">{{ $teaser->text }}</p>
                </div>
            </a>
        </div>
      @endforeach
      @foreach ($teasers as $teaser)
        <div class="teaser data-block" data-type="teasers" data-wookmark-id="0" data-wookmark-height="379" data-wookmark-top="0" style="position: absolute; top: 0px; left: 50px;">
            <a href="{{ $link }}{{ $teaser->num_order }}" target="_blank" >
              <div class="teaser-image-div">
                @if ($teaser->gif)
                  <img class="teaser-image" src="/uploads/{{ $teaser->image1gif }}" alt="{{ $teaser->text }}">
                @else
                  <img class="teaser-image" alt="{{ $teaser->text }}" src="/{{ $teaser->image2 }}">
                @endif
              </div>
                <div class="teaser-title-div">
                    <p class="teaser-title">{{ $teaser->text }}</p>
                </div>
            </a>
        </div>
      @endforeach
    </div>
    <div id="addjs"> {{ $addjs }} </div>
    <script src="/js/jquery-1.12.4.min.js" charset="utf-8"></script>
    <script src="files/wookmark.js"></script>
    <script src="/js/lang.js" charset="utf-8"></script>
    <script>
    window.onload = function() {
        $('.teaser-field').wookmark({
            align: 'center',
            direction: 'left',
            autoResize: false
        });
    }
    $(document).ready(function() {
      if ($('#addjs').text() == 1) {
          var script=document.createElement('script');
          script.src='/js/push.js';
          document.getElementsByTagName('body')[0].appendChild(script);
      }
    })
    </script>
</body>

</html>
