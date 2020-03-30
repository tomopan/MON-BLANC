<template>
  <div>
    <h1>読書ページ</h1>
    <v-container>
      <h1>『{{novelData.title}}』</h1>
      <p>作者：{{novelData.name}}</p>

      <FollowBtnComponent />

      <br />
      <v-divider></v-divider>
      <br />
      <!-- ダミーテキスト -->
      <p>{{episodeData.text}}</p>
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
import FollowBtnComponent from "../items/FollowBtnComponent.vue";

export default {
  components: {
    FollowBtnComponent
  },
  data() {
    return {
      novelData: [],
      episodeData: []
    };
  },

  created() {
    this.showNovel();
    this.showEpisode();
  },
  methods: {
    showNovel: function() {
      //Novelテーブルから情報を取得
      axios
        .get("api/get/novel/" + this.$route.params.novel_id)
        .then(res => {
          this.novelData = res.data;
          console.log(res);

          // console.log(res.data[0].title);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    showEpisode: function() {
      //Episodesテーブルから情報を取得
      axios
        .get("api/get/episode/" + this.$route.params.novel_id)
        .then(res => {
          this.episodeData = res.data[0];
          console.log(res.data);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    }
  }
};
</script>

<style scoped>
</style>