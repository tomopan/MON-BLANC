<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>TOP</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">


    </head>
    <body>
        <p>index.blade.php</p>
        <p>user_id:{{ Auth::id()}} </p>
        <div id="app">
        </div>
        <script>
            window.Laravel = {!! json_encode([
                'apiToken' => \Auth::user()->api_token ?? null
            ]) !!};
        </script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>