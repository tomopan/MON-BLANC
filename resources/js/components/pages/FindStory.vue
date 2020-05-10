<template>
  <v-container class="pa-4">
    <!-- 主人公から探す -->
    <div class="hero-find">

      <p class="futura"><span class="line">READ</span></p>
      <p class="rubi">よむ</p>
      <!-- タブ -->
      <v-tabs grow v-model="active_tab" show-arrows>
        <div>
          <v-tab @click="showNovels">すべて</v-tab>
        </div>
        <div v-for="hero of heroes" :key="hero.id">
          <v-tab @click="showHeroNovels(hero.id)">{{ hero.hero_name }}</v-tab>
        </div>
      </v-tabs>

      <!-- 新着表示 -->
      <v-row class="fill-height" align="center" justify="center">
        <div v-for="(novel, id) in Novels" :key="id" class="text">
          <v-col :key="id">
            <router-link
              :to="{
                  name: 'ReadPaper',
                  params: {
                    hero_id:novel.hero_id,
                     paper_novel_id: novel.id }
              }"
            >

            <!-- 主人公の画像 -->
            <figure class="relative">
              <v-img :src="'img/timeline/' + novel.img_url" class="backImage"></v-img>
              <div class="wrap">
                <div class="blank"></div>
                <div>
                  <figcaption class="absolute novelTitle"><p class="novelTitle title">{{novel.title}}</p></figcaption>
                  <!-- 最初の50文字 -->
                  <figcaption class="absolute novelText"><p class="novelText text">{{novel.text}}</p></figcaption>
                </div>
              </div>
            </figure>

            </router-link>
          </v-col>
        </div>

        <v-pagination
          v-model="page"
          :length="page_length"
          circle
          color="#b5bdd9"
          @input="changeShowNovels(page)"
        ></v-pagination>
      </v-row>
    </div>
  </v-container>
</template>
<script>
export default {
  components: {},

  data: () => ({
    heroes: [],
    title: "",
    allNovels: "",
    Novels: "",
    //タブ関係
    active_tab: 0,
    // ページネーション
    page: 1, //現在のページ
    page_length: 1, //ページネーションのタブの数
    parPage: 20 //1ページの表示数
  }),

  created() {
    //主人公を表示
    this.showHeroes();
    //小説を取得
    this.showNovels();
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
    },
    // 新着順で小説を取得
    showNovels: function() {
      axios
        .get("api/get/novels/")
        .then(res => {
          this.allNovels = res.data;
          //50字で省略
          this.allNovels.forEach(e => {
            if (e.text && e.text.length >= 50)
              e.text = e.text.substr(0, 50) + "・・・";
          });

          this.page_length = Math.ceil(this.allNovels.length / this.parPage);
          this.Novels = this.allNovels.slice(0, this.parPage);
          console.log(res.data);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    // 新着順で小説を取得
    showHeroNovels: function($hero_id) {
      axios
        .get("api/get/hero_novels/" + $hero_id)
        .then(res => {
          this.allNovels = res.data;
          this.page_length = Math.ceil(this.allNovels.length / this.parPage);
          this.Novels = this.allNovels.slice(0, this.parPage);
          console.log(res.data);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //ページネーションで表示する小説を切り替え
    changeShowNovels: function($page) {
      $page -= 1;
      this.Novels = this.allNovels.slice(
        $page * this.parPage,
        $page * this.parPage + this.parPage
      );
    }
  }
};
</script>

<style scoped>
.futura{
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
  text-align:center;
  margin-top: 3em;;

}
#app > div > main > div > div > p.futura{
  margin-bottom: 0.2em;
}
.rubi{
  font-size: 1.2em;
    text-align:center;

}
span{
  border-bottom:2px solid #000;
}

.novelTitle{
  margin-bottom: 1em!important;
  width: 180px;
  margin-top: 1em;

}
.novelText{
  margin-top: 6em!important;
  margin-bottom: 1em!important;
  width: 180px;
}

.title{
  font-weight: bold;
  font-size: 14px;
  color: #000;
}
.text{
  font-size: 10px;
}

.relative {
    position: relative;
    display:flex;
}

.backImage{
  width:400px;
}

.wrap{
  display: flex;
  justify-content: center;
  position: absolute;

}

.blank{
  height: 200px;
  width: 200px;
}

.absolute {
  position: absolute;
  top: 30px;
}

.novelText{
  margin-top: 3em;
  color: #000;
}

@media screen and (max-width: 415px) {
.rubi{
  font-size: 1em;
}
}

</style>
