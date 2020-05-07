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
        <div v-for="(novel, id) in Novels" :key="id">
          <v-col :key="id">
            <router-link
              :to="{
                                name: 'ReadPaper',
                                params: { paper_novel_id: novel.id }
                            }"
            >
              <!-- 主人公の画像 -->
              <v-img :src="'img/books/' + novel.img_url" width="200px"></v-img>
              <!-- タイトル -->
              <p>{{novel.title}}</p>
              <!-- 最初の50文字 -->
              <p>{{novel.text}}</p>
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

<style scoped></style>
