<html>

    <head>
        <title>好像出错了！！</title>
        <script type="text/javascript" src="{{ asset('home/js/jquery.js') }}"></script>
        <link href="{{ asset('home/css/bootstrap.min.css') }}" rel="stylesheet">

        <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
        <script>
            setTimeout(function(){
                window.location.href="{{$url or '/'}}";

            },3000)
        </script>
    </head>

    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ $info or "好像出现了点错误.."}}</div>
            </div>
        </div>
    </body>
</html>