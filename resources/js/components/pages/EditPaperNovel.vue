<template>
  <div>
    <div class="text-xs-center">
      <v-tabs v-model="tab" centered center-active @change="showPapers">
        <v-tab v-for="n in page_length" :key="n">{{ n }}</v-tab>
      </v-tabs>
    </div>
    <grid-layout
      :layout.sync="layout"
      :col-num="12"
      :row-height="50"
      :is-draggable="true"
      :is-resizable="false"
      :is-mirrored="true"
      :vertical-compact="false"
      :margin="[10, 10]"
      :use-css-transforms="true"
      :preventCollision="true"
    >
      <grid-item
        v-for="(paper, i) in active_page_novels"
        :x="paper.x"
        :y="paper.y"
        :w="paper.w"
        :h="paper.h"
        :i="i"
        :key="i"
        :class="{
                    title_paper: paper.titleToggle,
                    text_paper: !paper.titleToggle
                }"
      >
        <router-link
          v-if="paper.titleToggle"
          :to="{
                        name: 'WriteTitlePaper',
                        params: {
                            user_paper_order: $route.params.user_paper_order
                        }
                    }"
        >
          <p v-if="title_toggle" class="title_text">{{ paper.text }}</p>
          <p v-else class="title_text">タイトルを編集</p>
        </router-link>
        <router-link
          v-if="!paper.titleToggle"
          :to="{
                        name: 'EditStoryPaper',
                        params: {
                            hero_id:PaperNovelData.hero_id,
                            user_paper_order: $route.params.user_paper_order,
                            story_number: paper.story_number
                        }
                    }"
        >
          <p class="paper_text" v-html="paper.text.replace(/\\n|\r\n|\r|\n/g, '<br>')"></p>
        </router-link>
        <!-- ペーパー追加ボタン -->
        <router-link
          v-if="paper.add"
          :to="{
                        name: 'EditStoryPaper',
                        params: {
                            hero_id:PaperNovelData.hero_id,
                            user_paper_order: $route.params.user_paper_order,
                            story_number: story_number
                        }
                    }"
        >
          <v-btn class="add-btn" icon>
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </router-link>
      </grid-item>
    </grid-layout>

    <!-- ボタンたち -->
    <!-- 本完成ボタン -->
    <div>
      <v-img class="icon" src="img/write-page/book.png" @click="openNovel"></v-img>
      <br />
      <br />
      <br />
      <!-- 本追加ボタン -->
      <router-link
        :to="{
                    name: 'WriteStoryPaper',
                    params: {
                        user_paper_order: $route.params.user_paper_order,
                        story_number: story_number
                    }
                }"
      >
        <v-img class="icon" src="img/write-page/write.png"></v-img>
      </router-link>
      <br />
      <br />
      <br />
      <v-img class="icon" src="img/write-page/tutorial.png"></v-img>
      <br />
      <br />
      <br />
      <v-img class="icon" src="img/write-page/continue.png" @click="$router.go(-1)"></v-img>
    </div>
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
<script src="vue-grid-layout.umd.min.js"></script>
<script>
// インポート
import VueGridLayout from "vue-grid-layout";

// Vueの処理
export default {
  components: {
    GridLayout: VueGridLayout.GridLayout,
    GridItem: VueGridLayout.GridItem
  },
  data() {
    return {
      //GridLayout用
      layout: [],
      justify: ["start", "center", "end", "space-around", "space-between"],
      //showNovel()のデータ格納
      PaperNovelData: "",
      //showPapers()のデータ格納
      papers: [],
      //titleの判定
      title_toggle: false,
      story_number: "",
      // ページネイション
      page_length: [1],
      tab: null,
      active_page_novels: "",
      // モーダル
      dialog: false
    };
  },
  created() {
    this.showNovel();
    this.getPapers();
  },
  methods: {
    //ペーパーノベルの情報を取得
    showNovel: function() {
      axios
        .get("api/fetch/paper_novel/" + this.$route.params.user_paper_order)
        .then(res => {
          this.PaperNovelData = res.data;
          //タイトルの場合はtoggleをtrue
          if (this.PaperNovelData.title) this.title_toggle = true;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //ストーリーペーパーを取得
    getPapers: function() {
      axios
        .get("api/get/story_papers_edit/" + this.$route.params.user_paper_order)
        .then(res => {
          this.papers = res.data;
          //タイトルを挿入
          this.papers.unshift({
            text: this.PaperNovelData.title,
            titleToggle: true
          });
          //追加ボタン用のインデックスを追加
          // if (this.papers.length <= 5)
          this.papers.push({ text: "", add: true });
          //ページ数を計算
          const pageCount = Math.ceil(this.papers.length / 6);
          //2ページ以上の時、タブを増やす
          if (pageCount >= 2) {
            this.page_length = [...Array(pageCount).keys()]
              .map(i => ++i)
              .reverse();
          }
          this.showPapers(0);
          this.story_number = this.papers.length + 1;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    showPapers: function(tab) {
      let active_tab = tab;
      // 表示用の配列
      this.active_page_novels = this.papers.slice(
        active_tab * 6,
        active_tab * 6 + 6
      );
      console.log(this.active_page_novels);

      this.active_page_novels.forEach(function(e, i) {
        if (e.text && e.text.length >= 50)
          e.text = e.text.substr(0, 50) + "・・・";
        //位置を挿入
        if (i % 2 != 0) {
          e.x = i * 2 - 2;
          e.y = 6;
          e.w = 4;
          e.h = 6;
        } else {
          e.x = i * 2;
          e.y = 0;
          e.w = 4;
          e.h = 6;
        }
      });
    },
    openNovel: function() {
      // タイトルのバリデーション
      if (this.PaperNovelData.title == null) {
        this.dialog = true;
        return;
      }
      axios
        .post(
          "api/update/paper_novel_open/" + this.$route.params.user_paper_order
        )
        .then(res => {
          this.$router.push({
            name: "Complete",
            params: {
              user_paper_order: this.$route.params.user_paper_order
            }
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    closeNovel: function() {
      axios
        .post("update/paper_novel_close/" + this.$route.params.user_paper_order)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}

.paper_text {
  writing-mode: vertical-rl;
  margin: auto;
  position: absolute;
  right: 0;
}
/* .title_card {
} */
.title_text {
  writing-mode: vertical-rl;
  margin: 0 auto;
  margin-top: 5%;
}

.text_paper {
  border: 1px solid;
  position: relative;
}

.title_paper {
  border: 3px solid;
}

a,
p {
  color: #333;
  font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
    "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}

a:hover {
  text-decoration: none;
}

.icon {
  width: 100px;
  cursor: pointer;
  position: fixed;
}

.add-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}


</style>
