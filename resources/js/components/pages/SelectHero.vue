<template>
  <v-container class="pa-4 text-center">
    <v-row class="fill-height" align="center" justify="center">
      <!-- choice your charactorここから -->
      <v-container class="pa-4 text-center">
          <p class="futura"><span class="line">WRITE</span></p>
          <p class="rubi">かく</p>

        <!-- typerのtextのインデントこのままでお願いします -->
        <vue-typer
          :repeat="0"
          :type-delay="100"
          text="Choice your character, and Write your story.|"
          style="white-space:pre-line; word-wrap:break-word;"
          class="typer"
        ></vue-typer>
        <p class="first">あなたの物語の主人公を選んで、物語を書いてみよう。</p>
        <p>投稿された物語は、タイムラインに表示されます</p>
        <div class="wrap">
          <TopBase />
        </div>
      </v-container>
    </v-row>
  </v-container>
  <!-- </router-link> -->
</template>
<script>
import TopBase from "./TopBase.vue";

export default {
  components: {
    TopBase
  },

  data: () => ({
    heroes: []
  }),

  created() {
    //主人公を表示
    this.showHeroes();
  },

  methods: {
    //主人公の情報を取得
    showHeroes: function() {
      axios
        .get("api/get/hero")
        .then(res => {
          this.heroes = res.data;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};

  (function() {
    // スクロールを禁止する関数
    function noScroll(event) {
      event.preventDefault();
    }
    // スクロール禁止(SP)
    document.addEventListener('touchmove', noScroll, { passive: false });
    // スクロール禁止(PC)
    // document.addEventListener('mousewheel', noScroll, { passive: false });
  })();

</script>

<style scoped>
*:focus {
  outline: none;
}

a:hover {
  text-decoration: none;
}

.futura{
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
}
#app > div > main > div > div > div > p.futura{
  margin-bottom: 0.2em;
}
.rubi{
  font-size: 1.2em;
}
span.line{
  border-bottom:2px solid #000;
}


.v-card {
  transition: opacity 0.4s ease-in-out;
  color: #333333;
}

.v-card:not(.on-hover) {
  opacity: 0.8;
}

.typer{
  font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;
}

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
}

.stage {
  width: 100%;
  height: 400px;
}

.v-application .first{
  margin-bottom: 0;
}

@media screen and (max-width: 415px) {
  html, body {
  overflow: hidden;
  }

.vue-typer, .typer{
  font-size:14px;
}
p{
  font-size:12px;
}
.first{
  margin-top: 0.5em;
}
.rubi{
  font-size: 1em;
}

#people{
  width: 550px;
  height: 300px;
  object-fit: cover;
  margin-left: -6.1em;
}
}



</style>
<style>
#app > div > header {
  display: block;
}

.v-application--wrap{
  background-image: url(/img/write-page/background.jpg);
  background-repeat: no-repeat;
  background-size: cover;
}
</style>