<template>
  <div>
    <!-- エピソードタイトル入力 -->
    <v-form>
      <div class="input-area">
        <div id="episode_text">
          <p
            class="paper"
            contenteditable="true"
            id="episode_text_input"
            placeholder="新しいペーパーで小説を書く"
          ></p>
        </div>
      </div>
      <!-- 小説入力 -->

      <br />
      <!-- 保存ボタン -->
      <router-link :to="{name:'PaperEdit',param:{novel_id:episodePost.novel_id}}">
        <v-btn color="primary" id="save" dark @click="saveEpisode">保存する</v-btn>
      </router-link>
    </v-form>
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
      novelData: "",
      //タイトルとテキストを格納
      episodePost: {},
      hero: {}
    };
  },

  created() {
    this.episodePost.novel_id = this.$route.params.novel_id;
  },
  methods: {
    //一時保存：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを0
    saveEpisode: function() {
      //PostするオブジェクトにDOMの内容をぶちこむ
      //テキスト
      this.episodePost.text = document.getElementById(
        "episode_text_input"
      ).textContent;

      //小説id
      this.episodePost.novel_id = this.$route.params.novel_id;

      //ステータスを0
      this.episodePost.status = 0;

    //内容をPost
      axios
        .post("api/post/episode", this.episodePost)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });

    //ステータスを登録
      axios
        .post("api/update/novel/close/" + this.$route.params.novel_id)
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
[contenteditable="true"]:empty:before {
  content: attr(placeholder);
  pointer-events: none;
  display: block; /* For Firefox */
  color: #a9a9a9;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.paper {
  display: block;
  /* width: 10%; */
  margin: auto;
  margin-top: 10%;
  /* padding: 40px; */
  -webkit-writing-mode: vertical-rl;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  font-size: 20px;
  line-height: 2em;
  overflow-x: scroll;
  outline: none;
}

.paper span {
  display: block;
}
#save {
  display: block;
  margin: auto;
}
.input-area {
  margin: auto;
  padding-top: 50px;
  height: 600px;
  display: grid;
  grid-template-columns: 150px 1fr;
  border: 1px solid #000000;
}
#novel_title {
  margin: 0;
  padding-top: 50px;
  grid-row: 1 / 12;
  grid-column: 10 / 12;
  /* border: 1px solid #000000; */
}
#episode_text {
  grid-row: 1 / 12;
  grid-column: 1 / 10;
  /* border: 1px solid #000000; */

  /* display: grid; */
  /* grid-template-columns: 150px 1fr; */
}
#episode_text_input {
  margin: 0 50px 0 auto;
  /* border: 1px solid #000000; */
}
</style>

