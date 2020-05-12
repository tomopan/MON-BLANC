<template>
  <div class="cont">
    <!-- テキスト未入力の時のモーダル -->
    <div id="overlay" v-show="dialog">
      <div id="content">
        <div class="write">
          <p>テキストを入力してください</p>
          <button
            class="closeButton"
            style="border:solid 2px #000"
            @click="dialog = false"
          >&nbsp;閉じる&nbsp;</button>
        </div>
      </div>
    </div>
    <!-- モーダルここまで -->
    <!-- 文字数 -->
    <!-- ボタンたち -->
    <div class="buttons">
      <!-- 戻るボタン -->
      <div>
        <v-img
          :src="'/img/write-page/close.png'"
          class="close"
          alt="close"
          @click="$router.go(-1)"
        />
      </div>
      <!-- プレビューボタン -->
      <div>
        <v-img :src="'/img/write-page/preview.png'" class="close" alt="preview" />
      </div>
      <!-- 一時保存ボタン -->
      <div>
        <v-img :src="'/img/write-page/save.png'" class="close" alt="save" @click="editPaper" />
      </div>
      <!-- ヒント -->
      <div>
        <hint />
      </div>
      <!-- 主人公のアイコン -->
      <figure class="relative novel_title">
        <img class="hero-icon" :src="'img/charactors/' + HeroData.img_url" />
      </figure>
      <figcaption class="absolute fukidashi">
        <p class="novelText">{{ HeroData.hero_name }}</p>
        <p class="novelText">Age {{ HeroData.hero_birth }}</p>
      </figcaption>
    </div>

    <div class="count">{{charaCount}}/5000文字</div>

    <v-row>
      <!-- 小説入力 -->
      <div class="input-area">
        <!-- 小説入力 -->
        <div id="paper_text">
          <div
            v-if="PaperNovelData.text"
            class="paper"
            contenteditable="true"
            id="story_text_input"
          >
            <div>
              <!-- {{ PaperNovelData.text }} -->
            </div>
          </div>
          <div v-else class="paper" contenteditable="true" id="story_text_input" placeholder="テキスト"></div>
        </div>
      </div>
    </v-row>
    <!-- 入力エリアここまで -->
    <div class="episode_num">第{{$route.params.story_number}}話</div>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";
import Hint from "../items/Hint.vue";

// Vueの処理
export default {
  components: {
    Hint
  },
  data() {
    return {
      //ペーパーノベルの情報を格納
      PaperNovelData: "",
      //タイトルとテキストを格納
      PaperNovelPost: {},
      //最初か追加かを判定
      isFristStoryPaper: false,
      //モーダルの開閉
      dialog: false,
      //文字数カウント
      charaCount: ""
    };
  },

  created() {
    //主人公データを取得
    this.fetchHeroData(this.$route.params.hero_id);

    //Postデータにuser_paper_orderを入れる
    this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;
    //Postデータにhero_idを入れる
    this.PaperNovelPost.hero_id = this.$route.params.hero_id;
    console.log(this.PaperNovelPost.hero_id);
    //ペーパーノベルのデータを取得
    this.showNovel();
  },
  mounted() {
    this.stopText();
  },
  computed: {
    ...mapGetters(["HeroData"])
  },
  methods: {
    //API叩いてマッチした主人公データを取得
    ...mapActions(["fetchHeroData"]),

    //ストーリーペーパーの情報を取得
    showNovel: function() {
      axios
        .get(
          "api/fetch/story_paper/" +
            this.$route.params.user_paper_order +
            "/" +
            this.$route.params.story_number
        )
        .then(res => {
          this.PaperNovelData = res.data;
          //改行コードを<br>に変換
          this.PaperNovelData.text = this.PaperNovelData.text.replace(
            /\\n|\r\n|\r|\n/g,
            "<br/>"
          );
          $("#story_text_input").append(this.PaperNovelData.text);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //textを更新する
    editPaper: function() {
      //5000字以上だったらアラート表示
      if (document.getElementById("story_text_input").innerHTML.length > 5000)
        alert("5000字以内で入力してください");
      //PostするオブジェクトにDOMの内容をぶちこむ
      //テキスト
      this.PaperNovelPost.text = document
        .getElementById("story_text_input")
        .innerHTML.replace(/(<(p|div))/gi, "\\n$1")
        .replace(/(<([^>]+)>)/gi, "");
      //5000字で制限
      // テキストのバリデーション
      if (this.PaperNovelPost.text.length == 0) {
        this.dialog = !this.dialog;
        return;
      }

      //user_paper_order
      this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;

      // story_numberを格納
      this.PaperNovelPost.story_number = this.$route.params.story_number;

      //最初の一文が更新されていたら、paper_novelsテーブルも更新
      // if (this.$route.params.story_number == 2) {
      //   const firstSentence = this.PaperNovelPost.text.split("。")[0] + "。";
      //   this.PaperNovelPost.first_sentence = firstSentence;
      //   console.log(this.PaperNovelPost);
      //   // 更新
      //   axios
      //     .post("api/update/first_sentence", this.PaperNovelPost)
      //     .then(res => {
      //       console.log(res.data);
      //     })
      //     .catch(err => {
      //       console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
      //     });
      // }

      // ストーリーペーパーの内容を更新
      axios
        .post("api/edit/story_paper", this.PaperNovelPost)
        .then(res => {
          this.$router.push({
            name: "EditNovel",
            params: {
              user_paper_order: this.$route.params.user_paper_order
            }
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    // 5000字で制御
    stopText: function() {
      //要素のIDを取得
      const target = document.getElementById("story_text_input");

      //DOMの変更を監視
      const observer = new MutationObserver(records => {
        // 変化が発生したときの処理を記述
        let p = document.getElementById("story_text_input");
        //文字数をdataに格納
        let text = p.textContent;
        this.charaCount = text.length;
      });
      observer.observe(target, {
        // オプションを指定
        characterData: true,
        childList: true,
        subtree: true
      });
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}
.cont {
  height: 100%;
  padding: 5em;
  display: flex;
  background-color: #ffe8ae;
}

/* モーダル */
#modal_text {
  /* writing-mode: vertical-rl; */
  margin: auto;
  padding-top: 10%;
}
#content {
  z-index: 2;
  width: 30%;
  padding: 1em;
  background-color: #fff;
  border: 1px solid #000;
  font-weight: bold;
}
#overlay {
  /*要素を重ねた時の順番*/
  z-index: 1;

  /*画面全体を覆う設定*/
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);

  /*画面の中央に要素を表示させる設定*/
  display: flex;
  align-items: center;
  justify-content: center;
}

/* 入力 */
[contenteditable="true"]:empty:before {
  content: attr(placeholder);
  pointer-events: none;
  display: block; /* For Firefox */
  color: #a9a9a9;
}

/* 入力エリア */
.paper {
  display: block;
  margin: auto;
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
.input-area {
  margin: auto;
  padding-top: 1em;
  height: 600px;
  width: 800px;
  margin-top: 2em;
  display: grid;
  grid-template-columns: 150px 1fr;
  border: 1px solid #a9a9a9;
  background-color: white;
  cursor: url("/img/write-page/cursor.png"), auto;
  overflow-x: scroll;
  margin-bottom: 3em;
}
#paper_text {
  width: 800px;
  height: 500px;
}

#story_text_input > div {
  height: 582px;
  font-size: 18px;
}

#story_text_input {
  margin: 0 20px 0 auto;
  /* border: 1px solid #000000; */
}

p {
  text-align: center;
}
.write {
  text-align: center;
  background-color: #ffce97;
  margin: 1em;
  padding: 1em;
}

/* 話数 */
.episode_num {
  -webkit-writing-mode: vertical-rl;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  text-orientation: upright;
  margin: 2em 12em 5em -2em;
}
.count {
  margin: 30em 0em -3em 0em;
  /* margin-top: 30em; */
  writing-mode: vertical-rl;
  text-orientation: upright;
}

/* ボタン */
.buttons {
  display: flex;
  flex-direction: column-reverse;
  height: 120px;
  margin-left: 100px;
  margin-top: 500px;
}
.close {
  margin-top: 0.5em;
}
/* 主人公アイコン */
.hero-icon {
  width: 100px;
  top: 0;
}
/* 主人公アイコンホバー */
.novelTitle {
  margin-bottom: 0 !important;
  font-weight: bold;
}
.relative {
  position: relative;
}

.absolute {
  position: absolute;
  bottom: 0.6em;
  left: 3em;
}

.fukidashi {
  display: none;
  width: 100px;
  height: 100px;
  position: absolute;
  top: 200px;
  left: 10em;
  padding: 16px;
  border-radius: 15px;
  border: solid 3px #555;
  background: #fff;
  color: #000;
  font-weight: bold;
  z-index: 4;
}

.fukidashi:before {
  content: "";
  position: absolute;
  top: -24px;
  left: 70%;
  margin-left: -17px;
  border: 12px solid transparent;
  border-bottom: 12px solid #fff;
  z-index: 6;
}

.fukidashi:after {
  content: "";
  position: absolute;
  top: -30px;
  left: 70%;
  margin-left: -19px;
  border: 14px solid transparent;
  border-bottom: 14px solid #555;
  z-index: 5;
}

.novel_title:hover + .fukidashi {
  display: block;
}
</style>
<style>
#app > div > main {
  margin: 0px;
  height: 100%;
}

.close {
  opacity: 1;
}
</style>
