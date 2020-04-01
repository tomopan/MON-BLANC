<template>
  <div>
    <p>ペーパー編集ページ</p>
    <br />

    <!-- ペーパー表示 -->
    <v-container class="grey lighten-5">
      <v-row>
        <v-col v-for="(paper, i) in papers" :key="i" md="4">
          <!--ペーパー表示 -->
          <v-card style="height: 200px;width:400px" tile outlined>
            <p class="paper_text">{{paper.text}}</p>
          </v-card>
          <!-- 小説入力 -->
        </v-col>
      </v-row>
    </v-container>

    <!-- ペーパー追加ボタン -->
    <router-link :to="{name:'AddPaper',params:{novel_id:$route.params.novel_id}}">
      <v-btn class="mx-2">
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
    </router-link>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート

// Vueの処理
export default {
  components: {},
  data() {
    return {
      papers: "",
      //タイトルとテキストを格納
      justify: ["start", "center", "end", "space-around", "space-between"]
    };
  },

  created() {
    this.showPapers();
  },
  methods: {
    //小説のペーパーを取得
    showPapers: function() {
      axios
        .get("api/get/papers/" + this.$route.params.novel_id)
        .then(res => {
          console.log(res);
          this.papers = res.data;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },

    //一時保存：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを0
    saveEpisode: function() {
      //PostするオブジェクトにDOMの内容をぶちこむ
      //タイトル
      this.episodePost.title = document.getElementById(
        "novel_title"
      ).textContent;
      //テキスト
      this.episodePost.text = document.getElementById(
        "episode_text_input"
      ).textContent;

      //小説id
      this.episodePost.novel_id = this.$route.params.novel_id;

      //ステータスを0
      this.episodePost.status = 0;

      axios
        .post("api/post/episode", this.episodePost)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });

      axios
        .post("api/update/novel/close/" + this.$route.params.novel_id)
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
.paper_text {
  writing-mode: vertical-rl;
  position: absolute;
  right: 0;
}
</style>

