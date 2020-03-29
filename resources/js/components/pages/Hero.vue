<template>
<div>
    <h1>主人公ページ</h1>
    <!-- 主人公の画像 -->
      <v-img
        :src="hero.img_url"
        height="400px"
        width="400px"
      >
        <v-card-title class="title white--text">
            <v-row
            class="fill-height flex-column"
            justify="space-between"
            >
            <p class="mt-4 subheading text-left" style="color:white">主人公ID : {{hero.id}}</p>
            <p class="mt-4 subheading text-left" style="color:white">名前 : {{hero.hero_description}}</p>
            </v-row>
        </v-card-title>
      </v-img>

    <!-- 執筆ボタン -->
    <router-link :to="{name:'NovelTitle',params:{hero_id:$route.params.hero_id}}">
      <v-btn class="ma-2" tile outlined color="success">
          <v-icon left>mdi-pencil</v-icon> 執筆する
      </v-btn>
    </router-link>

  <!-- 書かれている小説を表示 -->
  <ul>
    <li v-for="novel in novels" :key="novel.id">
      {{novel.title}}
    </li>
  </ul>

</div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
import WriteBtnComponent from "../items/WriteBtnComponent.vue";
import HeroImgComponent from "../items/HeroImgComponent.vue";



export default {
  components: {
    WriteBtnComponent,
    HeroImgComponent,
  },

  data() {
    return {
      hero:{},
      novels:[]
    };
  },
  watch: {
    // ルートが変更されたらこのメソッドを再び呼び出します
    '$route': 'showHero'
  },
  created() {
    //hero_idに遷移した主人公idを代入
    this.showHero();
    this.showNovels();
  },
  methods: {
    //API叩いてマッチした主人公データを取得
    showHero:function(){
        axios
            .get("api/get/hero/"+this.$route.params.hero_id)
            .then(res => {
              console.log(res.data)
              this.hero = res.data[0];
            })
            .catch(err => {
              console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
      },
    //主人公に書かれている小説のタイトルを表示
    showNovels:function(){
        axios
            .get("api/get/novels/"+this.$route.params.hero_id)
            .then(res => {
              console.log(res.data)
              this.novels = res.data;
            })
            .catch(err => {
              console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
      },
  },

 
};
</script>

<style scoped>

</style>