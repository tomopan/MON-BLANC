<template>
  <v-container class="pa-4 text-center">
    <div class="hero-find">
      <p class="futura">
        <span class="line">BOOKMARK</span>
      </p>
      <p class="rubi">ブックマーク</p>

      <!-- ブックマーク -->
      <v-row class="fill-height" align="center" justify="center">
        <div v-for="(bookmarkNovel, i) in BookmarkNovels" :key="i" class="text">
          <v-col :key="id">
            <router-link
              :to="{
                      name: 'ReadPaper',
                      params: {
                          hero_id: bookmarkNovel.hero_id,
                          paper_novel_id: bookmarkNovel.paper_novel_id
                      }
                  }"

                >
                  <!-- 主人公の画像 -->
                  <figure class="relative novel_title">
                    <v-img :src="'img/flamebooks/' + bookmarkNovel.img_url" width="250px" class=" novel_title"></v-img>
                    <figcaption class="absolute novel_title"><p class="novelTitle novel_title">{{ bookmarkNovel.title }}</p></figcaption>
                  </figure>
                  <figcaption class="absolute fukidashi"><p class="novelText">{{ bookmarkNovel.text }}</p></figcaption>
                </router-link>
              </v-col>
              <!-- 削除ボタン -->
              <!-- <v-btn class="ma-2" tile outlined @click.native.stop="dialog = true">削除</v-btn> -->
              <!-- 削除のモーダル -->
              <!-- <v-layout row justify-center>

                <v-dialog v-model="dialog" max-width="290">
                  <v-card>
                    <v-card-title class="headline">削除しますか?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn @click.native="dialog = false">戻る</v-btn>
                      <v-btn
                        @click="
                            destroy(i, bookmarkNovel.id)
                        "
                      >削除する</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
          </v-layout>-->
          <!-- モーダルここまで -->
        </div>
      </v-row>
    </div>
  </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
  components: {
    //執筆中の小説のエピソード名を格納
  },
  data() {
    return {
      //非公開のペーパーノベルのデータを格納
      BookmarkNovels: [],
      // グリッド用
      alignmentsAvailable: ["start", "center", "end", "baseline", "stretch"],
      alignment: "center",
      dense: false,
      justifyAvailable: [
        "start",
        "center",
        "end",
        "space-around",
        "space-between"
      ],
      justify: "center",
      dialog: false
    };
  },
  watch: {
    $route(to, from) {
      // ルートの変更の検知
      if (to.path !== from.path) {
        this.showBookmarks();
      }
    }
  },
  created() {
    // this.showWritedEpisode();
    this.showBookmarks();
  },
  methods: {
    showBookmarks: function() {
      axios
        .get("api/get/bookmarks")
        .then(res => {
          console.log(res.data);
          this.BookmarkNovels = res.data;
          //50字で省略
          this.BookmarkNovels.forEach(e => {
            if (e.text && e.text.length >= 50)
              e.text = e.text.substr(0, 50) + "・・・";
          });
          //タイトルを16字で省略
          this.BookmarkNovels.forEach(e => {
            if (e.title && e.title.length >= 9)
              e.title = e.title.substr(0, 8) + "...";
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    destroy(i, $bookmark_id) {
      axios
        .post("api/destroy/bookmark/" + $bookmark_id)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.BookmarkNovels.splice(i, 1);
      //モーダルを閉じる
      this.dialog = false;
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}


span.line{
  border-bottom:2px solid #000;

}

.novel_card {
  text-align: center;
}

.v-btn {
  color: #333;
}
p {
  color: #333;
}
.row{
  margin-bottom: 7em;
}

.futura {
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
}
#app > div > main > div > div > p.futura {
  margin-bottom: 0.2em;
}
.rubi {
  font-size: 1.2em;
}
span {
  border-bottom: 2px solid #000;
}

.novelTitle{
  margin-bottom: 0!important;
  font-weight: bold;

}
.relative {
  position: relative;
}

.absolute {
    position: absolute;
    bottom: 0.6em;
    left:3em;
}

.fukidashi {
  display: none;
  width: 250px;
  height: 160px;
  position: absolute;
  top: 200px;
  left: -1em;
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
  border-bottom: 12px solid #FFF;
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

.novelText{
  text-align: left;
  font-weight: normal;
}


@media screen and (max-width: 415px) {
  .rubi {
    font-size: 1em;
  }
}
</style>
