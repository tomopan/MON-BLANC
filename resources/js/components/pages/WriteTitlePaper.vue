<template>
  <div class="cont">
    <!-- ボタンたち -->
    <div class="buttons">
      <!-- 戻るボタン -->
      <v-img :src="'/img/write-page/close.png'" class="close" alt="close" @click="$router.go(-1)" />
      <!-- あとでボタン -->
      <router-link
        :to="{
            name: 'EditStoryPaper',
            param: {
              hero_id: this.$route.params.hero_id,
              user_paper_order: this.$route.params.user_paper_order,
              story_number: this.$route.params.story_number
            }
            }"
      >
        <v-img :src="'/img/write-page/atode.png'" class="close" alt="preview" />
      </router-link>
      <!-- 保存ボタン -->
      <v-img :src="'/img/write-page/save.png'" class="close save" alt="save" @click="saveTitle" />
      <!-- ヒント -->
      <Hint />
    </div>
    <!-- ボタンここまで -->
    <!-- 入力エリア -->
    <div class="wrap-input-area">
      <div class="input-area">
        <div id="paper_text">
          <p
            v-if="title_toggle"
            class="paper"
            contenteditable="true"
            id="novel_title"
            placeholder="小説のタイトルを入力してください"
          >{{ novelData.title }}</p>
          <p
            v-else
            class="paper"
            contenteditable="true"
            id="novel_title"
            placeholder="小説のタイトルを入力してください"
          ></p>
        </div>
        <!-- 入力エリアここまで -->
      </div>
      <p class="paper">小説のタイトル</p>
    </div>
    <div></div>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import Hint from "../items/Hint.vue";

// Vueの処理
export default {
  components: {
    Hint
  },
  data() {
    return {
      //タイトルを判定
      title_toggle: false,
      //showNovel()のデータを格納
      novelData: "",
      //タイトルとテキストを格納
      titlePost: {}
    };
  },

  created() {
    this.showNovel();
  },
  methods: {
    //ペーパーノベルの情報を取得
    showNovel: function() {
      axios
        .get("api/fetch/paper_novel/" + this.$route.params.user_paper_order)
        .then(res => {
          console.log(res);
          this.novelData = res.data;

          if (this.novelData.title) this.title_toggle = true;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },

    //タイトルペーパーをPaperNovelsテーブルに保存
    saveTitle: function() {
      //PostするオブジェクトにDOMの内容をぶちこむ
      //タイトル
      this.titlePost.title = document.getElementById("novel_title").textContent;

      // Post
      axios
        .post(
          "api/update/paper_title/" + this.$route.params.user_paper_order,
          this.titlePost
        )
        .then(res => {
          this.$router.push({
            name: "EditNovel",
            param: {
              user_paper_order: this.$route.params.user_paper_order
            }
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
/* 全体 */
*:focus {
  outline: none;
}
.cont {
  height: 100%;
  display: flex;
  justify-content: space-around;
  padding-top: 2em;
  background-color: #ffe8ae;
}

/* 小見出し */
.write {
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  background-color: #ffce97;
  text-align: center;
  margin: 1em;
}

/* モーダル */
#modal_text {
  /* writing-mode: vertical-rl; */
  margin: auto;
  padding-top: 10%;
}
#content {
  z-index: 2;
  width: 100%;
  padding: 1em;
  background-color: #fff;
  border: 1px dashed #000;
}

/* 入力 */
[contenteditable="true"]:empty:before {
  content: attr(placeholder);
  pointer-events: none;
  display: block; /* For Firefox */
  color: #a9a9a9;
}

/* 入力エリア */
.wrap-input-area {
  display: flex;
  margin-bottom: 3em;
}
.paper {
  display: block;
  -webkit-writing-mode: vertical-rl;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  word-wrap: break-word;
  white-space: pre-wrap;
  font-size: 18px;
  line-height: 2em;
  overflow-x: scroll;
  outline: none;
}
.paper span {
  display: block;
}
.min{
  font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;
  cursor: url("/img/write-page/cursor.png"), auto;

}
.input-area {
  margin: auto;
  padding-top: 1em;
  height: 600px;
  width: 100px;
  margin-top: 2em;
  border: 1px solid #a9a9a9;
  background-color: white;

}
#story_text_input {
  display: block;
  margin: auto;
  height: 582px;
}
#story_text_input > div {
  height: 582px;
  font-size: 18px;
}

/* ボタン */
.buttons {
  display: flex;
  justify-content: center;
  flex-direction: column-reverse;
  height: 100px;
  margin-left: 5em;
  margin-top: 330px;
}
.close{
  opacity: 1;
  margin-top: 0.5em;
}
</style>
<style>
#app > div > main {
  margin: 0px;
  height: 100%;
}
</style>