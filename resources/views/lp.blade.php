<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="4;URL=/lpScroll">.
    <title>MON BLANC</title>
    <style>
        *:focus {
        outline: none;
        }
        img{
            width:300px;
        }
        p{
            font-size:60px;
            font-family:'Bradley Hand';
        }
        .wrap{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:  center;
        }
        .welcome{
            margin-top:2em;
        }
        .library{
            margin-top:1em;
        }
        #images {
            width:300px;
            height:200px;
            margin: 0 auto;
            text-align: left;
            overflow: hidden;
            position: relative;
        }

        #images img {
            top: 0;
            left: 0;
            position: absolute;
        }

    </style>

</head>
<body>
    <div class="wrap">
        <div><img class="welcome" src="{{asset('img/lp/welcome.png')}}" alt="welcome"></div>
        <div><img class="logo" src="{{asset('img/lp/logo.png')}}" alt="logo"></div>
            <div id="images">
                    <img class="library" src="{{asset('img/lp/library.png')}}" alt="library">
                    <img class="library" src="{{asset('img/lp/libraryColor.png')}}" alt="libraryColor">
            </div>
        <div><p class="stayHome">Stay home, stay safe with story.</p></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function(){
                var setImg = '#images';
                var fadeSpeed = 1400;
                var switchDelay = 2000;

                $(setImg).children('img').css({opacity:'0'});
                $(setImg + ' img:first').stop().animate({opacity:'1',zIndex:'20'},fadeSpeed);

                setTimeout(function(){
                    $(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
                },switchDelay);
            });
    </script>

</body>
</html>