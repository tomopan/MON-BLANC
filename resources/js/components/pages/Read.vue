<template>
  <div>
    <h1>読書ページ</h1>
    <v-container>
    <HeroImgComponent/>
        <h1>『{{novel_title}}』</h1>
        <p>作者：{{user_id}}</p>
        <FollowBtnComponent/>
        <br>
        <p>第{{episode_number}}話　{{episode_title}}</p>
        <v-divider></v-divider>
        <br>
        <!-- ダミーテキスト -->
        <p>
          {{text}}
        </p>
        <!-- 章の移動ボタン -->
      <v-btn class="ma-2" color="orange darken-2" dark>
        <v-icon dark left>mdi-arrow-left</v-icon>Back
      </v-btn>

      <v-btn class="ma-2" color="orange darken-2">
        <v-icon dark left>mdi-arrow-right</v-icon>NEXT
      </v-btn>

    </v-container>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
import HeroImgComponent from "../items/HeroImgComponent.vue";
import FollowBtnComponent from "../items/FollowBtnComponent.vue";

export default {
  components: {
    HeroImgComponent,
    FollowBtnComponent
  },
  data() {
    return {
        name:"かわべ",
        user_id:"@kawabe",
        follower_count:77,
        follow_count:777,
        novel_title:"",
        episode_title:"",
        episode_number:null,
        text:""
    };
  },

  created() {
    this.showNovelInfo();
    this.showEpisodeInfo();
  },
  methods: {
    showNovelInfo:function(){
      //Novelテーブルから情報を取得
      axios
        .get("api/get/novel/")
        .then(res => {
          this.novel_title =res.data[0].title;
          console.log(res.data[0].title);
        })
        .catch(err => {
          console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜
          })
    },
    showEpisodeInfo:function(){
      //Episodesテーブルから情報を取得
        axios
        .get("api/get/episode/")
        .then(res => {
          this.episode_title =res.data[0].episode_title;
          this.episode_number =res.data[0].episode_number;
          this.text =res.data[0].text;
          console.log(res.data[0]);
        })
        .catch(err => {
          console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜
          })
    }
  }
};
</script>

<style scoped>

</style>