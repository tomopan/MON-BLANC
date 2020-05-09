<template>
  <div>
    <!-- <p>マークされた数：{{ MarkCount }}</p>
        <p>選択中ストーリー番号：{{ markedStoryId }}</p>
    <p>選択中テキスト：{{ markedText }}</p>-->
    <v-row justify="center">
      <!-- 本エリア -->
      <div class="book-caver">
        <div id="book" class="paper" @mouseup="getMarkText()">
          <!-- 表紙 -->
          <div class="story_text hard">
            <v-img :src="'img/books/' + coverImg" />
          </div>
          <!-- タイトル&作者 -->
          <div class="story_text hard">
            <span class="title_text">{{ this.Title }}</span>
            <br />
            <br />
            <span class="title_writer">
              作者：
              <router-link
                :to="{
                                        name: 'Profile',
                                        params: {
                                            user_name: WriterData.user_name
                                        }
                                    }"
              >{{ WriterData.name }}</router-link>
            </span>
          </div>
          <div id="insert_area">
            <!-- ここに文章が挿入される -->
          </div>
          <div class="hard">
            <v-img height="640px" width="538px" :src="'img/book_cover/' + coverImg" />
          </div>
        </div>
      </div>
      <!-- ボタンエリア -->
      <div v-if="$store.state.login" class="btns">
        <!-- ブックマークボタン（切り替え） -->
        <v-icon v-if="!bookmarkToggle" color="#000" @click="saveBookmark" large>mdi-bookmark-outline</v-icon>
        <v-icon v-else-if="bookmarkToggle" color="#000" @click="deleteBookmark" large>mdi-bookmark</v-icon>
        <!-- ツイートボタン -->
        <img class="icon" src="/img/sns/Twitter_Logo_Blue.png" alt @click="openTweet" />
      </div>
      <!-- ボタンエリアここまで -->
    </v-row>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
  components: {},
  data() {
    return {
      //小説のデータ
      StoryPapersData: [],
      // 表紙画像
      coverImg: "",
      //タイトル
      Title: "",
      //作者のデータ
      WriterData: {},
      MarkCount: "",
      //選択したテキストを格納
      markedText: "",
      markedStoryId: "",
      postMarkedText: {},
      // ブックマークしてるか
      bookmarkToggle: "",
      dialog: false
    };
  },

  created() {
    this.showTitle();
    this.showStoryPapers();
    this.checkBookmark();
    this.showMarkCount();
  },
  mounted() {
    this.$nextTick(function() {
      const test = document.getElementById("book");
    });
  },
  methods: {
    showStoryPapers: function() {
      //StoryPapersテーブルから情報を取得
      axios
        .get("api/get/story_papers/" + this.$route.params.paper_novel_id)
        .then(res => {
          this.StoryPapersData = res.data;
          console.log(this.StoryPapersData);
          //改行コードを<br>に変換
          this.StoryPapersData.forEach(el => {
            el.text = el.text.replace(/\\n|\r\n|\r|\n/g, "<br>");
            // DOMを追加（ここからじゃないとTurn.js使えない）
            $("#insert_area").append(
              "<div class='story_text' style='writing-mode: vertical-rl; background-color:#fff'><span>" +
                el.text +
                "</span></div>"
            );
          });
          
          //   奇数ページの時は最後に白紙を追加
          if (this.StoryPapersData.length % 2 == 0) {
            $("#insert_area").append(
              "<div class='story_text' style='writing-mode: vertical-rl; background-color:#fff'></div>"
            );
          }

          // 親要素のタグだけ削除
          $(".story_text").unwrap("#insert_area");
          // turn.jsを発動
          this.turnPage();
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    showTitle: function() {
      //PaperNovelsテーブルからタイトルを取得
      axios
        .get(
          "api/fetch/paper_novel_titile/" + this.$route.params.paper_novel_id
        )
        .then(res => {
          //非公開の場合はtopへリダイレクト
          if (res.data.status == 0) {
            this.$router.push({
              name: "SelectHero"
            });
          } else {
            this.Title = res.data.title;
            this.WriterData.name = res.data.name;
            this.WriterData.user_name = res.data.user_name;
            this.coverImg = res.data.img_url;
          }
          console.log(res.data);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    //マーカー機能
    getMarkText: function() {
      //要素のIDを取得
      const story_area = document.getElementsByClassName("story_area");
      //テキストを代入
      const selectedText = window.getSelection().toString();
      this.markedText = selectedText;
      //ストーリー番号を代入
      this.markedStoryId = 1;
    },
    saveMarkText: function() {
      //POSTするデータを格納
      //小説id
      this.postMarkedText.paper_novel_id = this.$route.params.paper_novel_id;
      //ストーリーid
      this.postMarkedText.story_paper_id = this.markedStoryId;
      //テキスト
      this.postMarkedText.text = this.markedText;
      axios
        .post("api/post/mark_text", this.postMarkedText)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    showMarkCount: function() {
      //マークされている数を取得して格納
      axios
        .get("api/get/mark_count/" + this.$route.params.paper_novel_id)
        .then(res => {
          this.MarkCount = res.data;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    // ブックマークする
    saveBookmark: function() {
      axios
        .post("api/post/bookmark/" + this.$route.params.paper_novel_id)
        .then(res => {
          this.checkBookmark();
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    // ブックマークを外す
    deleteBookmark: function() {
      axios
        .post("api/destroy/bookmark/" + this.bookmarkToggle)
        .then(res => {
          this.checkBookmark();
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    // ブックマークしてるか確かめる
    checkBookmark: function() {
      axios
        .get("api/check/bookmark/" + this.$route.params.paper_novel_id)
        .then(res => {
          console.log(res.data);
          if (!res.data) this.bookmarkToggle = false;
          else this.bookmarkToggle = res.data[0].id;
          console.log(this.bookmarkToggle);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
        });
    },
    // turn.jsの処理
    turnPage: function() {
      // DOMを追加（ここからじゃないとTurn.js使えない）
      $("#book").turn({
        direction: "rtl",
        width: 1076,
        height: 700
      });
    },
    // ツイート機能
    openTweet: function() {
      let text = `MON BLANCの小説を共有します！
https://mon-blanc.com${this.$route.path}`;
      let url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(
        text
      )}`;
      let w = 640;
      let h = 360;
      let x = (screen.width - w) / 2;
      let y = (screen.height - h) / 2;
      window.open(
        url,
        null,
        "left=" +
          x +
          ",top=" +
          y +
          ",width=" +
          w +
          ",height=" +
          h +
          ",status=no"
      );
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}

.container {
  font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
    "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}

/* ---------------------------
            本の仕様
--------------------------- */

/* 全体 */


/* 表紙 */

/* 文章 */

/* 裏表紙 */

.book-caver {
  margin-top: 10px;
}
.book {
  margin: 100px;
}
.paper {
  margin: auto;
  height: 640px;
}
.story_text {
  -webkit-writing-mode: vertical-rl;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  font-size: 30px;
  line-height: 2em;
  overflow-x: scroll;
  outline: none;
  background-color: white;
}
.title_text {
  font-size: 30px;
}
.title_area {
  -webkit-writing-mode: vertical-rl;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  margin-right: 30%;
  text-align: center;
  justify-content: baseline;
}
.title_writer {
  margin-top: 50%;
}

/* 裏表紙 */
.book_cover {
  height: 640px;
}

/* ---------------------------
            ボタン
--------------------------- */
.icon {
  width: 100px;
  cursor: pointer;
}
</style>
