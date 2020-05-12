<template>
      <v-row :align="alignment" :justify="justify" style="height: 300px;">
        <div
          v-for="(openNovel, i) in OpenPaperNovels"
          :key="i"
          width="200px"
          height="200px"
          class="novel_card ma-4"
        >
          <v-hover v-slot:default="{ hover }" open-delay="100">
            <div>
              <v-img :src="'img/flamebooks/' + openNovel.img_url" width="250px">
              <router-link
                :to="{
                        name: 'ReadPaper',
                        params: {
                            hero_id: openNovel.hero_id,
                            paper_novel_id: openNovel.id
                        }
                    }"
              >
                <p class="paper_text absolute novelTitle">{{ openNovel.title }}</p>
              </router-link>

                <v-expand-transition>
                  <div
                    v-if="hover"
                    class="d-flex center transition-fast-in-fast-out white darken-2 v-card--reveal display-3 white--text"
                    style="height: 100%;"
                  >
                <div
                  v-if="
                          loginUserName == $route.params.user_name
                      "
                >
                  <router-link
                    :to="{
                          name: 'EditNovel',
                          params: {
                              user_paper_order:
                                  openNovel.user_paper_order
                          }
                      }"
                  >
                    <v-btn :class="{ 'show-btns': hover } " class="mx-2 hoverButton" color="transparent" tile outlined>編集</v-btn>
                  </router-link>
                  <v-btn
                    class="ma-2 hoverButton"
                    tile
                    outlined
                    :class="{ 'show-btns': hover }"
                    color="transparent"
                    @click="
                                            closeNovel(
                                                i,
                                                openNovel.user_paper_order
                                            )
                                        "
                  >非公開にする</v-btn>
                  <v-btn
                    class="mx-2 mt-2 mb-5 hoverButton"
                    tile
                    outlined
                    :class="{ 'show-btns': hover }"
                    color="transparent"
                    @click.native.stop="dialog = true"
                  >削除</v-btn>
                  <!-- 削除のモーダル -->
                  <v-layout row justify-center>
                    <v-dialog v-model="dialog" max-width="290">
                      <v-card>
                        <v-card-title class="headline">削除しますか?</v-card-title>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            @click.native="
                                                            dialog = false
                                                        "
                          >戻る</v-btn>
                          <v-btn
                            @click="
                                                            destroy(
                                                                i,
                                                                openNovel.id
                                                            )
                                                        "
                          >削除する</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </v-layout>
                  <!-- モーダルここまで -->
                </div>
                </div>
                </v-expand-transition>
              </v-img>

            </div>
          </v-hover>
        </div>
      </v-row>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
  props: {
    //ログイン中のuser_nameをもらう
    loginUserName: {
      type: String
    }
  },
  data() {
    return {
      //公開中のペーパーノベルのデータを格納
      OpenPaperNovels: [],
      dialog: false,
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
      justify: "center"
    };
  },
  watch: {
    $route(to, from) {
      // ルートの変更の検知
      if (to.path !== from.path) {
        this.showNovelsOpened();
      }
    }
  },
  created() {
    this.showNovelsOpened();
  },
  methods: {
    //ペーパーノベルを取得
    showNovelsOpened: function() {
      axios
        .get("api/get/open_paper_novels/" + this.$route.params.user_name)
        .then(res => {
          this.OpenPaperNovels = res.data.map(data => {
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
          this.OpenPaperNovels.forEach(e => {
            if (e.title && e.title.length >= 9)
              e.title = e.title.substr(0, 8) + "...";
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //非公開ボタン
    closeNovel: function(i, user_paper_order) {
      axios
        .post("api/update/paper_novel_close/" + user_paper_order)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.OpenPaperNovels.splice(i, 1);
    },
    //削除ボタン
    destroy(i, paper_novel_id) {
      axios
        .post("api/destroy/paper_novel/" + paper_novel_id)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.OpenPaperNovels.splice(i, 1);
      this.dialog = false;
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}

.font {
  font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
    "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}

.novel_card {
  text-align: center;
}

.v-btn {
  color: #000;
}

p {
  color: #000;
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
