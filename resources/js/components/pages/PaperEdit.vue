<template>
  <div>
    <p>ペーパー編集ページ</p>
    <br />

    <grid-layout
      :layout.sync="layout"
      :col-num="12"
      :row-height="30"
      :is-draggable="true"
      :is-resizable="false"
      :is-mirrored="true"
      :vertical-compact="false"
      :margin="[10, 10]"
      :use-css-transforms="true"
      :preventCollision="true"
    >
      <grid-item
        v-for="(paper, i) in papers"
        :x="paper.x"
        :y="paper.y"
        :w="paper.w"
        :h="paper.h"
        :i="i"
        :key="i"
        :class="{'title_paper':i==0,'text_paper':i!=0}"
      >
        <router-link
          v-if="i == 0"
          :to="{
                name: 'WriteTitle',
                param: { novel_id: novelData.novel_id }
            }"
        >
          <p v-if="title_toggle" class="title_text">{{ paper.text }}</p>
          <p v-else class="title_text">タイトルを入力してください</p>
        </router-link>
        <p v-if="i != 0" class="paper_text">{{ paper.text }}</p>
      </grid-item>
    </grid-layout>

    <!-- ペーパー追加ボタン -->
    <router-link
      :to="{
                name: 'AddPaper',
                params: { novel_id: $route.params.novel_id }
            }"
    >
      <v-btn class="mx-2">
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
    </router-link>
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
      //テスト
      layout: [],
      //showNovel()のデータ格納
      novelData: "",
      //showPapers()のデータ格納
      papers: [],
      //titleの判定
      title_toggle: false,
      //UI用
      justify: ["start", "center", "end", "space-around", "space-between"]
    };
  },

  created() {
    this.showNovel();
    this.showPapers();
    //タイトルの情報をpapersに格納

    console.log(this.papers);
  },
  methods: {
    //小説の情報を取得
    showNovel: function() {
      axios
        .get("api/get/novel/" + this.$route.params.novel_id)
        .then(res => {
          console.log(res);
          this.novelData = res.data;

          if (this.novelData.title) this.title_toggle = true;
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //小説のペーパーを取得
    showPapers: function() {
      axios
        .get("api/get/papers/" + this.$route.params.novel_id)
        .then(res => {
          this.papers = res.data;
          this.papers.unshift({
            text: this.novelData.title
          });
          this.papers.forEach(function(e, i) {
            if (i % 2 != 0) {
              e.x = i - 1;
              e.y = 6;
              e.w = 2;
              e.h = 5;
            } else {
              e.x = i;
              e.y = 0;
              e.w = 2;
              e.h = 5;
            }
          });

          console.log(this.papers);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
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
}

.title_paper {
  border: 3px solid;
}
</style>
