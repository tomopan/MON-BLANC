<template>
  <v-container class="pa-4 text-center">
    <!-- 主人公から探す -->
    <div class="hero-find">

      <p>READ</p>
      <p>よむ</p>
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
              <v-img :src="'img/flamebooks/' + novel.img_url" width="200px"></v-img>
              <figcaption class="absolute"><p class="novelTitle">{{novel.title}}</p></figcaption>
              <!-- 最初の50文字 -->
              <figcaption class="absolute"><p class="novelTitle">{{novel.text}}</p></figcaption>
            </figure>

            </router-link>
          </v-col>
        </div>
        <!-- 吹き出し部分 -->

        <p class="fukidashi">ある朝のことだ。スミレはふと思った。「ああ、私は幸せも・・・</p>

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
.en{
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
}
#app > div > main > div > div > p.en{
  margin-bottom: 0.2em;
}
.rubi{
  font-size: 1.2em;
}
span{
  border-bottom:2px solid #000;
}

.novelTitle{
  margin-bottom: 0!important;
}
.relative {
    position: relative;
}
.relative:hover{
  
}

.absolute {
    position: absolute;
    bottom: 0.3em;
    left:2.8em
}

    /* .fukidashi {
      display: none;
      width: 200px;
      position: absolute;
      top: 0;
      left: 250px;
      padding: 16px;
      border-radius: 5px;
      background: #33cc99;
      color: #fff;
      font-weight: bold;
    }
    .fukidashi:after {
      position: absolute;
      width: 0;
      height: 0;
      left: 0;
      bottom: -19px;
      margin-left: 10px;
      border: solid transparent;
      border-color: rgba(51, 204, 153, 0);
      border-top-color: #33cc99;
      border-width: 10px;
      pointer-events: none;
      content: " ";
    }
    .text:hover + .fukidashi {
      display: block;
    } */
</style>
