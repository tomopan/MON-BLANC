<template>
  <div>
    <p>新規エピソードを作成</p>

    <p>{{hero.hero_description}}</p>
    <!-- <p>小説ID：{{$route.params.novel_id}}</p> -->
    <p>小説タイトル：{{novelTitle.title}}</p>
    <!-- {{episodePost}} -->

    <!-- エピソードタイトル入力 -->
    <v-form>
      <v-text-field label="エピソードタイトル" id="episode_title" v-model="episodePost.episode_title"></v-text-field>
      <!-- 小説入力 -->
      <v-textarea counter rows="10" label="エピソード" v-model="episodePost.text"></v-textarea>
      <!-- 一時保存ボタン -->
      <router-link :to="{name:'Profile'}">
        <v-btn color="primary" id="save" dark @click="saveEpisode">一時保存</v-btn>
      </router-link>
      <!-- 公開ボタン -->
      <router-link :to="{name:'Hero',params:{hero_id:$route.params.hero_id}}">
        <v-btn color="success" id="open" dark @click="openEpisode">公開</v-btn>
      </router-link>
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
    HeroImgComponent
  },
  data() {
    return {
      novelTitle: "",
      //タイトルとテキストを格納
      episodePost: {},
      hero: {}
    };
  },

  created() {
    this.episodePost.novel_id = this.$route.params.novel_id;
    this.showHero();
    this.showNovel();
  },
  methods: {
    //主人公を表示する
    showHero: function() {
      axios
        .get("api/get/hero/" + this.$route.params.hero_id)
        .then(res => {
          console.log(res.data);
          this.hero = res.data[0];
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },

    //小説の情報を取得する
    showNovel: function() {
      axios
        .get("api/get/novel/" + this.$route.params.novel_id)
        .then(res => {
          console.log(res);
          this.novelTitle = res.data;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },

    //一時保存：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを0
    saveEpisode: function() {
      //ステータスを0
      this.episodePost.status = 0;

      axios
        .post("api/post/episode", this.episodePost)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });

      axios
        .post("api/update/novel/close/"+this.episodePost.novel_id)
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //公開：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを1
    openEpisode: function() {
      //ステータスを1
      this.episodePost.status = 1;

      axios
        .post("api/post/episode", this.episodePost)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
</style>

