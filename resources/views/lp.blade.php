<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MON BLANC</title>
    <style>
        *:focus {
        outline: none;
        }
        img{
            width:300px;
        }
        p{
            font-size:40px;
            font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;
            color:#2C2B2B;
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
        .color,.stayHome{
            opacity:0;
        }
        .sp_br{
            display:none;
        }

        .welcome{
            width:200px;
            margin-bottom: 1em;
        }

        .wrap{
            margin-top: 4em;
        }


        @media screen and (max-width: 415px) {
        p{
            font-size:30px;
            text-align:center;
        }
        .sp_br{
            display:block;
        }

        }
    </style>

</head>
<body>
    <div class="wrap">
        <div><img class="welcome" src="{{asset('img/lp/welcome.png')}}" alt="welcome"></div>
        <div><img class="logo" src="{{asset('img/lp/logo.png')}}" alt="logo"></div>
            <div id="images">
                    <img class="library" src="{{asset('img/lp/library.png')}}" alt="library">
                    <img class="library color" src="{{asset('img/lp/libraryColor.png')}}" alt="libraryColor">
            </div>
        <div><p class="stayHome">Stay home, stay safe <br class="sp_br">with story.</p></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function(){
                var setImg = '#images';
                var fadeSpeed = 1400;
                var switchDelay = 1500;

                $(setImg).children('img').css({opacity:'0'});
                $(setImg + ' img:first').stop().animate({opacity:'1',zIndex:'20'},fadeSpeed);

                setTimeout(function(){
                    $(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
                },switchDelay);
            });

                setTimeout(function(){
                    $(".stayHome").stop().animate({opacity:'1'},1000);
                },1000);

                setTimeout(function(){
                    window.location.href = '/lpScroll';
                }, 3*1000);
    </script>

</body>
</html>