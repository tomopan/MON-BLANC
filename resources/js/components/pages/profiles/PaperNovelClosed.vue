<template>
  <div class="font">
        <v-row :align="alignment" :justify="justify" style="height: 300px;">
          <div
            v-for="(closeNovel, i) in closePaperNovels"
            :key="i"
            width="200px"
            height="200px"
            class="novel_card ma-4"
          >
            <v-hover v-slot:default="{ hover }" open-delay="100">
              <div>
                <!-- <v-img :src="'img/uncomplete.png'" width="250px" height="300px"> -->
                <v-img :src="'img/flamebooks/' + closeNovel.img_url" width="250px">
                  <p class="paper_text absolute novelTitle">{{ closeNovel.title }}</p>
                <v-expand-transition>
                  <div
                    v-if="hover"
                    class="d-flex center transition-fast-in-fast-out white darken-2 v-card--reveal display-3 white--text"
                    style="height: 100%;"
                  >

                  <v-btn
                    class="ma-2 hoverButton"
                    tile
                    outlined
                    :class="{ 'show-btns': hover }"
                    color="transparent"
                    @click="
                            openNovel(
                                i,
                                closeNovel.user_paper_order,
                                closeNovel.title
                            )
                        "
                  >公開する</v-btn>
                  <router-link
                    :to="{
                            name: 'EditNovel',
                            params: {
                                user_paper_order:
                                    closeNovel.user_paper_order
                            }
                        }"
                  >
                    <v-btn :class="{ 'show-btns': hover }" class="mx-2 hoverButton" color="transparent" tile outlined>編集</v-btn>
                  </router-link>
                  </div>
                </v-expand-transition>
                </v-img>
              </div>
            </v-hover>
          </div>
        </v-row>
    <!-- タイトル未入力の時のモーダル -->
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="300">
        <v-card>
          <v-card-title class="headline">物語のタイトルを書きましょう</v-card-title>
          <v-card-text>ヒントから考えるのも、良いかもしれません</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog = false">閉じる</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <!-- モーダルここまで -->
  </div>
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
      closePaperNovels: [],
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
        this.showNovelsClosed();
      }
    }
  },
  created() {
    // this.showWritedEpisode();
    this.showNovelsClosed();
  },
  methods: {
    showNovelsClosed: function() {
      axios
        .get("api/get/close_paper_novels")
        .then(res => {
          console.log(res);
          this.closePaperNovels = res.data.map(data => {
            const obj = {};
            obj["id"] = data.id;
            obj["title"] = data.title;
            obj["hero_id"] = data.hero_id;
            obj["novel_id"] = data.id;
            obj["img_url"] = data.img_url;
            obj["user_paper_order"] = data.user_paper_order;
            return obj;
          });
          //タイトルを16字で省略
          this.closePaperNovels.forEach(e => {
            if (e.title && e.title.length >= 9)
              e.title = e.title.substr(0, 8) + "...";
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    openNovel: function(i, user_paper_order, title) {
      // タイトルのバリデーション
      if (title == null) {
        this.dialog = true;
        return;
      }
      axios
        .post("api/update/paper_novel_open/" + user_paper_order)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.closePaperNovels.splice(i, 1);
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
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
a{
  text-decoration: none;
}

/* ホバー時に出すボタン */
.show-btns {
  color: rgba(0, 0, 1) !important;
}

.v-card--reveal {
  align-items: center;
  bottom: 0;
  flex-direction: column;
  justify-content: center;
  opacity: .7;
  position: absolute;
  width: 100%;
}

.hoverButton{
  border-radius: 3px;
  background-color: #fff;
  opacity:1;
  display: block;
  justify-content: center;

}

.hoverButton:hover{
  border-radius: 3px;
  background-color: #ffe7ad;
  opacity:1;
  justify-content: center;

}
.novelTitle{
  margin-bottom: 0!important;
  font-weight: bold;
}
.absolute {
    position: absolute;
    bottom: 0.6em;
    left:3em;
}

</style>
