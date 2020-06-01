<template>
  <div>
    <div class="content">
      <div v-for="(paper, i) in papers" :key="i">
        <div v-if="paper.titleToggle" class="add_wrap">
          <!-- ボタンたち -->
          <!-- エピソード追加ボタン -->
          <router-link
            :to="{
                                name: 'EditStoryPaper',
                                params: {
                                    hero_id:PaperNovelData.hero_id,
                                    user_paper_order: $route.params.user_paper_order,
                                    story_number: story_number
                                }
                            }"
          >
            <v-btn class="add-btn btn">エピソードを追加</v-btn>
          </router-link>
          <!-- 本完成ボタン -->
          <v-btn class="open-btn btn" @click="openNovel">公開する</v-btn>
        </div>

        <div class="title_wrap">
          <div v-if="paper.titleToggle" class="title_wrap">
            <div v-if="title_toggle" class="title_text">{{ paper.text }}</div>
            <div v-else class="title_text">タイトルを編集しましょう！</div>
          </div>
          <div v-if="paper.titleToggle">
            <router-link
              :to="{
                              name: 'WriteTitlePaper',
                              params: {
                                  user_paper_order: $route.params.user_paper_order
                              }
                          }"
            >
              <v-btn class="btn title-btn">タイトルを編集</v-btn>
            </router-link>
          </div>
        </div>
        <div v-if="!paper.titleToggle">
          <p class="episode_text">第{{i}}話</p>
          <p class="paper_text" v-html="paper.text.replace(/\\n|\r\n|\r|\n/g, '<br>')"></p>
          <div class="buttonRight">
            <!-- <button class="btn epi_button">プレビュー</button> -->
            <router-link
              :to="{
                          name: 'EditStoryPaper',
                          params: {
                              hero_id:PaperNovelData.hero_id,
                              user_paper_order: $route.params.user_paper_order,
                              story_number: paper.story_number
                          }
                      }"
            >
              <button class="btn epi_button">編集</button>
            </router-link>

            <!-- 削除のモーダル -->
            <v-dialog v-model="DeleteDialog" max-width="290">
              <div id="modal-cont">
                <div class="write">
                  <p>第{{selectedOrder}}話を削除しますか？</p>
                  <br />
                  <button
                    style="border:solid 2px #000;"
                    @click="DeleteDialog = false"
                  >&nbsp;戻る&nbsp;</button>
                  <br />
                  <br />
                  <button
                    style="border:solid 2px #000;"
                    @click="destroy(PaperNovelData.id,selectedStory,selectedOrder)"
                  >&nbsp;削除する&nbsp;</button>
                </div>
              </div>
            </v-dialog>
            <!-- モーダルここまで -->
            <v-btn class="btn epi_button" @click="deleteModal(paper.story_number,i)">削除</v-btn>
          </div>

          <v-divider></v-divider>
          <!-- タイトル未入力の時のモーダル -->
          <v-dialog id="overlay" v-model="dialog" width="50%">
            <div id="modal-cont">
              <div class="write">
                <p>タイトルを入力してください</p>
                <button style="border:solid 2px #000;" @click="dialog = false">&nbsp;閉じる&nbsp;</button>
              </div>
            </div>
          </v-dialog>
          <!-- モーダルここまで -->
        </div>
      </div>
    </div>
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
      dialog: false,
      DeleteDialog: false,
      selectedStory: "",
      selectedOrder: ""
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
          //ページ数を計算
          // const pageCount = Math.ceil(this.papers.length / 6);
          // //2ページ以上の時、タブを増やす
          // if (pageCount >= 2) {
          //   this.page_length = [...Array(pageCount).keys()]
          //     .map(i => ++i)
          //     .reverse();
          // }
          // this.showPapers(0);
          this.story_number =
            this.papers[this.papers.length - 1].story_number + 1;
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
    },
    //削除ボタン
    destroy(paper_novel_id, story_number, selected_order) {
      axios
        .post("api/destroy/episode/" + paper_novel_id + "/" + story_number)
        .then(res => {})
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.papers.splice(selected_order, 1);
      this.DeleteDialog = false;
    },
    deleteModal(story_number, selected_order) {
      this.selectedStory = story_number;
      this.selectedOrder = selected_order;
      this.DeleteDialog = true;
    }
  }
};
</script>

<style scoped>
*:focus {
  outline: none;
}
.content {
  margin: 3% 10%;
  padding: 4%;
  background: #fff;
}

.paper_text {
  margin: auto;
  right: 0;
}
/* .title_card {
} */
.title_text {
  font-size: 1.3em;
  font-weight: bold;
}
.episode_text {
  font-size: 20px;
  font-weight: bold;
}
/* .text_paper {
} */

.add_wrap {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 3em;
}

.title_paper {
  border: 3px solid;
}

a,
p {
  color: #333;
  font-family: YuGothic, "Yu Gothic", "Yu Gothic UI", "Hiragino Sans",
    "ヒラギノ角ゴシック", "メイリオ", Meiryo, "ＭＳ Ｐゴシック", "MS PGothic",
    sans-serif;
}

a:hover {
  text-decoration: none;
}

p {
  margin-bottom: 0.2em;
}

.buttonRight {
  display: flex;
  justify-content: flex-end;
}

.epi_button {
  border: 1px solid #000;
  padding: 0.2em;
  font-size: 12px;
  background-color: #fff !important;
}

.icon {
  width: 100px;
  cursor: pointer;
  /* position: fixed; */
}

.title_wrap {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1em;
}

.add-btn {
  background-color: #d2e8d6 !important;
  color: #000;
}
.add-btn:hover {
  background-color: rgb(228, 249, 232) !important;
}

.open-btn {
  background-color: #fcc8db !important;
  color: #000;
}
.open-btn:hover {
  background-color: rgb(254, 226, 236) !important;
}

.title-btn {
  background-color: #c9eff5 !important;
  color: #000;
}
.title-btn:hover {
  background-color: rgb(218, 243, 247) !important;
}

.btn {
  margin: 0.5em 0.2em;
  padding: 8px;
  border-radius: 14px;
  text-align: center;
  cursor: pointer;
  font-weight: bold;
}
.editButton {
  margin: auto 1em;
}

/* モーダル */
/* 小見出し */
.write {
  font-family: "Futura", "游ゴシック体", "YuGothic";
  font-weight: bold;
  background-color: #ffce97;
  text-align: center;
  margin: 1em;
}

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
#modal-cont {
  z-index: 2;
  width: 100%;
  padding: 1em;
  background-color: #fff;
  border: 1px dashed #000;
}
@media screen and (max-width: 480px) {

#app > div > main > div > div.content{
  margin-top:80px;
}
.title_wrap {
    display: block;
    margin-bottom: 1em;
}
}
</style>
