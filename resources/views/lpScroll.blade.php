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
        body{
            background-color:#FFE8AF;
            margin : 0;
            padding : 0;
            overflow-x: hidden;
        }

        .blank{
            height:400px;
            display:block;
        }

        p{
            font-family: YuGothic,'Yu Gothic','Yu Gothic UI','Hiragino Sans','ヒラギノ角ゴシック','メイリオ', Meiryo,'ＭＳ Ｐゴシック','MS PGothic',sans-serif;
            color:#4B4949;
            opacity:85%;
        }

        .white{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:  center;
            letter-spacing:0.5em;
            background-image:url({{asset('img/write-page/background.jpg')}});
            background-size: cover;
            height:700px;
            background-color:rgba(255,255,255,0.7);
            background-blend-mode:lighten;
        }

        .pre{
            font-size:1.8em;
            text-align:center;
            margin-block-start: 0!important;
            margin-block-end: 0!important;
        }

        .mainMessage{
            font-size:3em;
            text-align:center;
            letter-spacing:0.2em;
        }

        span{
            font-family: "Futura","游ゴシック体", "YuGothic";
        }

        .orange{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:  center;
        }

        .card{
            background-color:#fff;
            border-radius:15px;
            display: flex;
            justify-content: space-between;
            align-items:  center;
            padding:2em 2.5em;
            margin:2em 2em 4em 2em;
            width:800px;
            height:400px;
            box-shadow:8px 8px 8px rgba(0,0,0,0.16);
        }
        .title{
            font-weight:bold;
            font-size:1.8em;
            letter-spacing:0.15em;
            margin-block-start: 0.1em;
            margin-block-end: 0.1em;
        }
        .mainTitle{
            text-align:center;
            margin-top:3em;
            margin-bottom:0;
            font-size:2.5em;
            letter-spacing:0.2em;
        }


        img{
            height:300px;
            margin: 0 30px;
        }
        .right{
            text-align:right;
        }
        .sentences{
            margin:4em 0;
            letter-spacing:0.2em;
        }

        .sentence{
            margin-block-start: 0.2em;
            margin-block-end: 0.2em;
            font-size:0.9em;
            line-height:24px;
        }

        button{
            background-color:#100D08;
            opacity:32%;
            color:#EFECEC;
            width:300px;
            margin:1em 1em 4em 1em;
            padding:8px;
            border-radius:14px;
            font-size:20px;
            letter-spacing:1em;
            text-align:center;
            text-indent:1em;
            cursor: pointer;
        }
        button:hover{
            background-color:#4f3f26;
        }


        .sp_br{
            display:none;
        }
        .pc_br{
            display:block;
        }

        @media screen and (max-width: 415px) {
        .pre{
            font-size:18px;
            text-align:center;
            margin-bottom:0;
        }
        .blank{
            height:560px;
            display:block;
        }
        .card{
            flex-direction: column;
            justify-content: center;
            width:250px;
            height:500px;
            padding:1em 2.5em;
            margin:2em 2em 4em 2em;
        }
        img{
            height:200px;
        }
        button{
            border-radius:40px;
        }
        .sentence{
            font-size:0.9em;
        }
        .title{
            font-size:18px;
            text-align:center;
            margin:0em auto 0 auto;
        }
        .mainTitle{
            margin-top:3em;
        }

        .sentences{
            font-size:12px;
            text-align:center;
        }
        .mainMessage{
            font-size:2em;
            text-align:center;
            letter-spacing:0.2em;
            margin-top:1em;
        }
        .right{
            text-align:center;
        }

        .meet{
            order:1;
        }
        button{
            width:250px;
            font-size:18px;

        }
        .sp_br{
            display:block;
        }
        .pc_br{
            display:none;
        }

        }

    </style>

</head>
<body>
    <div class="wrap">
        <div class="white">
            <div>
                <p class="pre">一言で表現できない物事に<br class="sp_br">直面したとき<br class="pc_br">物語は<br class="sp_br">初めてその意義を発揮する。</p>
                <p class="mainMessage">小説は、<br class="sp_br">「読む」から<br class="sp_br">「書く」へ。</p>
            </div>
        </div>
        <div class="orange">
            <div class="first">
                <p class="mainTitle title"><span>MON BLANC</span> での過ごし方</p>
                <div class="card">
                    <div>
                        <p class="title">物語の主人公を選ぼう。</p>
                        <div class="sentences">
                            <p class="sentence">あなたの気になる主人公が見つかれば、</p>
                            <p class="sentence">その気になった理由こそが、</p>
                            <p class="sentence">物語のアイディアです。</p>
                        </div>
                    </div>
                    <img src="{{asset('img/lp/characters_home.png')}}" alt="">
                </div>
            </div>
            <div class="second">
                <div class="card">
                    <img class="meet" src="{{asset('img/lp/meet.png')}}" alt="">
                    <div class="right">
                        <p class="title">思いついたままに</p>
                        <p class="title">描写してみよう！</p>
                        <div class="sentences">
                            <p class="sentence">質問に答えながら描写を<br class="sp_br">イメージしてみましょう。</p>
                            <p class="sentence">小説は自由です。</p>
                            <p class="sentence">イメージしたままに、<br class="sp_br">言葉にしてみてください。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="third">
                <div class="card">
                    <div>
                        <p class="title">主人公を起点に</p>
                        <p class="title">読みたい物語を選ぼう。</p>
                        <div class="sentences">
                            <p class="sentence">1人の主人公に対して、</p>
                            <p class="sentence">様々な視点での物語が綴られています。</p>
                            <p class="sentence">視点や側面の「違い」を、</p>
                            <p class="sentence">ぜひ楽しんでください。</p>
                        </div>
                    </div>
                    <img src="{{asset('img/lp/find.png')}}" alt="">
                </div>
            </div>
            <button onclick="location.href='{{url('/')}}'">はじめる</button>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">

        $('head').append(
        '<style>body{display:none;}'
        );
        $(window).on("load", function() {
        $('body').delay(600).fadeIn(1000);
        });
    </script>

</body>
</html>