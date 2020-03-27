<template>
<div>
    <p>新規エピソードを作成</p>
    <p>Hero_id : {{hero_id}}</p>
    <HeroImgComponent/>

    <p>ルネ・デカルト▶︎『風の歌を聴け』▶︎第1話</p>
    <!-- タイトル入力 -->
    <v-form>
    <v-text-field
      label="エピソードタイトル"
      id="episode_title"
      v-model="episodePost.episode_title"
    ></v-text-field>
    <!-- 小説入力 -->
      <v-textarea
      counter
      rows="10"
      label="エピソード"
      v-model="episodePost.text"
    ></v-textarea>
    <!-- 一時保存ボタン -->
    <v-btn color="primary" id="save" dark @click="saveEpisode">一時保存</v-btn>
    <!-- 公開ボタン -->
    <v-btn color="success" id="open" dark @click="openEpisode">公開</v-btn>
    </v-form>
</div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import WriteSideNav from "../items/WriteSideNav.vue";
import HeroImgComponent from "../items/HeroImgComponent.vue";


// Vueの処理
export default {
  components: {
    WriteSideNav,
    HeroImgComponent,
  },
  data() {
    return {
      //タイトルとテキストを格納
      episodePost:{},
      hero_id:""
    };
  },

  created() {
    this.episodePost.hero_id = this.hero_id;
  },
  methods: {
    //一時保存：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを0
    saveEpisode:function(){
      //ステータスを0
        this.episodePost.status = 0;
        // this.episodePost.hero_id = this.hero_id;
         axios
          .post("api/post/episode",this.episodePost)
          .then(res => {
          })
          .catch(err => {
            console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
    },
    //公開：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを1
    openEpisode:function(){
      //ステータスを1
        this.episodePost.status = 1;
         axios
          .post("api/post/episode",this.episodePost)
          .then(res => {
          })
          .catch(err => {
            console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
    }
  }
};
</script>

<style scoped>

</style>

