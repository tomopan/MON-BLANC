<template>
  <v-container class="pa-4 text-center">
    <v-row class="fill-height" align="center" justify="center">
      <!-- choice your charactorここから -->
      <v-container class="pa-4 text-center">
        <vue-typer
          :repeat="0"
          :type-delay="100"
          text="Choice your character, and Write your story.|"
          style="font-size:30px"
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
</script>

<style scoped>
*:focus {
  outline: none;
}

a:hover {
  text-decoration: none;
}

.v-card {
  transition: opacity 0.4s ease-in-out;
  color: #333333;
}

.v-card:not(.on-hover) {
  opacity: 0.8;
}

p {
  font-family: "Apple SD Gothic Neo", "serif";
}

.typer{
  font-family: "Kaiti SC", "serif";
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

</style>
<style>
#app > div > header {
  display: block;
}

.v-application--wrap{

  background-image: url(/img/write-page/background.jpg)!important;
  background-repeat: no-repeat;
  background-size: cover;

}
</style>