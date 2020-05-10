<template>
  <v-container class="pa-4 text-center">
    <div class="hero-find">
          <p class="futura"><span class="line">BOOKMARK</span></p>
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
                  <figure class="relative">
                    <v-img :src="'img/flamebooks/' + bookmarkNovel.img_url" width="200px"></v-img>
                    <figcaption class="absolute"><p class="novelTitle">{{ bookmarkNovel.title }}</p></figcaption>
                    <!-- 最初の50文字 -->
                    <!-- <figcaption class="absolute"><p class="novelTitle">{{bookmarkNovel.text}}</p></figcaption> -->
                  </figure>
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
              </v-layout> -->
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

.futura{
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
}
#app > div > main > div > div > p.futura{
  margin-bottom: 0.2em;
}
.rubi{
  font-size: 1.2em;
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

.futura{
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 2em;
}
#app > div > main > div > div > p.futura{
  margin-bottom: 0.2em;
}
.rubi{
  font-size: 1.2em;
}
span{
  border-bottom:2px solid #000;
}

.novelTitle{
  margin-bottom: 0!important;
}
.relative {
    position: relative;
}

.absolute {
    position: absolute;
    bottom: 0.3em;
    left:2.8em
}


@media screen and (max-width: 415px) {
.rubi{
  font-size: 1em;
}
}

</style>
