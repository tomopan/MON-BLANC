<template>
  <div class="cont">
    <!-- 戻るボタンエリア -->
    <div id="turn_area">
      <img id="turn_icon" class="icon" src="img/book-bg/uturn.png" @click="$router.go(-1)" />
    </div>
    <!-- 本エリア -->
    <div class="wrap_book">
      <div id="book" @mouseup="getMarkText()">
        <!-- 表紙 -->
        <div class="book_cover hard">
          <img :src="'img/books/' + coverImg" />
        </div>
        <!-- タイトル&作者 -->
        <div class="title_area hard">
          <span class="title_text">{{ this.Title }}</span>
          <br />
          <br />
          <span class="title_writer hard">
            <router-link
              :to="{
                                        name: 'Profile',
                                        params: {
                                            user_name: WriterData.user_name
                                        }
                                    }"
            >
              <p style="color:#333">{{ WriterData.name }}</p>
            </router-link>
          </span>
        </div>
        <div id="insert_area">
          <!-- ここに文章が挿入される -->
        </div>
        <div class="book_cover hard">
          <v-img :src="'img/book_cover/' + coverImg" />
        </div>
      </div>
    </div>
    <!-- ボタンエリア -->
    <div v-if="$store.state.login" class="btns">
      <!-- ブックマークボタン（切り替え） -->
      <v-icon
        v-if="!bookmarkToggle"
        size="60px"
        color="#000"
        @click="saveBookmark"
      >mdi-bookmark-outline</v-icon>
      <v-icon
        v-else-if="bookmarkToggle"
        size="60px"
        color="#000"
        @click="deleteBookmark"
      >mdi-bookmark</v-icon>
      <br />
      <!-- ツイートボタン -->
      <img class="icon" src="/img/sns/Twitter_Logo_Blue.png" alt @click="openTweet" />
    </div>
    <!-- ボタンエリアここまで -->
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
      // ページごとに表示するテキストデータ
      showText: [],
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
  mounted() {},
  methods: {
    showStoryPapers: function() {
      //StoryPapersテーブルから情報を取得
      axios
        .get("api/get/story_papers/" + this.$route.params.paper_novel_id)
        .then(res => {
          this.StoryPapersData = res.data;
          // 表示用の配列に420文字ずつ格納
          this.StoryPapersData.forEach((el, i) => {
            // エピソードを挿入
            el.text = `第${i + 1}話\n\n${el.text}`;
            //改行の数をカウント
            const lineCodeCount = (el.text.match(/\\n|\r\n|\r|\n/g) || [])
              .length;
            //文字数(改行コードを引く)
            const charaCount = el.text.length - lineCodeCount * 2;
            // 行数を計算
            const lineCount = Math.ceil(lineCodeCount + charaCount / 32);
            console.log(lineCount);
            // 15行以下ならそのままpush
            if (lineCount <= 15) {
              this.showText.push({
                text: el.text
              });
            }
            // 15行以上なら分割
            else {
              const t = [...el.text];
              let textCount = 0;
              let lineCount = 2;
              let start = 0;
              let cutText = [];
              let text = t.reduce((acc, c, i) => {
                if (acc + c == "\\n") {
                  lineCount += 1;
                  textCount =0;
                }
                else {
                  textCount += 1;
                  if (textCount == 32) {
                    lineCount += 1;
                    textCount = 0;
                  }
                }
                if (lineCount == 15) {
                  cutText.push(t.slice(start, i).join(""));
                  start = i;
                  lineCount = 0;
                }
                return c;
              });
              cutText.push(t.slice(start).join(""));
              
              cutText.forEach((el, i) => {
                this.showText.push({ text: el });
              });
            }

            // 420文字以下なら、そのままpush
            // if (el.text.length <= 420) {
            //   this.showText.push({
            //     text: el.text
            //   });
            // } else {
            //   const t = [...el.text];
            //   let text = t.reduce(
            //     (acc, c, i) =>
            //       i % 420 ? acc : [...acc, t.slice(i, i + 420).join("")],
            //     []
            //   );
            //   text.forEach((el, i) => {
            //     this.showText.push({ text: el });
            //   });
            // }
          });

          //改行コードを<br>に変換
          this.showText.forEach((el, i) => {
            el.text = el.text.replace(/\\n|\r\n|\r|\n/g, "<br>");
            // ページの文字数を制限
            // DOMを追加（ここからじゃないとTurn.js使えない）
            // ページごとにエフェクトを変更
            if (i % 2 == 1) {
              $("#insert_area").append(
                "<div class='story_text hard own-size' style='width:480px;height:650px; writing-mode:vertical-rl; text-orientation: upright;background-color:#fff;font-size:20px;background: -moz-linear-gradient(right, #FFF 90%, #e6e6e6);background: -webkit-linear-gradient(right, #FFF 90%, #e6e6e6);background: linear-gradient(to left, #fff 90%, #e6e6e6);'>" +
                  "<span class='text_area'><br/>" +
                  el.text +
                  "</span></div>"
              );
            } else {
              $("#insert_area").append(
                "<div class='story_text hard own-size' style='width:480px;height:650px;writing-mode: vertical-rl; text-orientation: upright;background-color:#fff;font-size:20px;background: -moz-linear-gradient(left, #FFF 90%, #e6e6e6);background: -webkit-linear-gradient(left, #FFF 90%, #e6e6e6);background: linear-gradient(to right, #fff 90%, #e6e6e6);'>" +
                  "<span><br/>" +
                  el.text +
                  "</span></div>"
              );
            }
          });

          //   奇数ページの時は最後に白紙を追加
          if (this.showText.length % 2 == 0) {
            $("#insert_area").append(
              "<div class='story_text hard' style='writing-mode: vertical-rl; background-color:#fff;background: -moz-linear-gradient(left, #FFF 90%, #e6e6e6);background: -webkit-linear-gradient(left, #FFF 90%, #e6e6e6);background: linear-gradient(to right, #fff 90%, #e6e6e6);'></div>"
            );
          }

          // 親要素のタグだけ削除
          $(".story_text").unwrap("#insert_area");
          // turn.jsを発動
          this.turnPage();
          // $(".story_text").css({ padding: "50px" });
          // $(".story_text").css({position:'absolute',top:'50%',left:'50%',transform:' translate(-50%, -50'});

          // $(".story_text").unwrap("div");
          // $(".story_text").css("padding", "50px");
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
          if (!res.data) this.bookmarkToggle = false;
          else this.bookmarkToggle = res.data[0].id;
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
        width: 1000,
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

.cont {
  font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
    "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
  background-color: white;
  display: flex;
  justify-content: center;
  height: 100%;
  padding-top: 5em;
}

/* ---------------------------
            本の仕様
--------------------------- */

/* 全体 */
.book_caver {
  width:500px;
  height:700px;
  width:100%;
  height:100%;
}
#book > div:nth-child(1) > div:nth-child(1) > div > img{
  width:500px;
  height:700px;
}

#book {
  /* height: 600px; */
  /* width: 500px;
  height: 700px; */
  /* position: absolute; */
}

/* 表紙 */
.p1 {
  /* width: 600px;
  height: 640px; */
}


/* タイトル */
.title_area {
  -webkit-writing-mode: vertical-rl;
  background: -moz-linear-gradient(right, #fff 90%, #e6e6e6);
  background: -webkit-linear-gradient(right, #fff 90%, #e6e6e6);
  background: linear-gradient(to left, #fff 90%, #e6e6e6);
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  text-orientation: upright;
  margin-right: 30%;
  text-align: center;
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
}
.title_text {
  font-size: 30px;
}
.title_writer {
  font-size: 30px;
  margin-right: 200px;
}

/* 文章 */

/* 裏表紙 */

/* 裏表紙 */
.book_cover {
  /* width: 500px;
  height: 700px; */
}

/* ---------------------------
            ボタン
--------------------------- */
.icon {
  width: 60px;
  cursor: pointer;
}
#turn_area {
  position: relative;
  /* height: 700px; */
}
#turn_icon {
  position: absolute;
  bottom: 7em;
  right: 2em;
}
</style>
<style>
/* レスポンシブ */
@media screen and (max-width: 480px) {
#book{
    width:300px;
  height:500px;

}
.book_caver {
  width:300px;
  height:500px;
  width:100%;
  height:100%;
}
#book > div:nth-child(1) > div:nth-child(1) > div > img{
  width:300px;
  height:500px;
}
#book > div:nth-child(1) > div:nth-child(1) > div{
  width:300px;
  height:500px;
}
#book > div:nth-child(1) > div{
  width:300px;
  height:500px;

}
}


</style>