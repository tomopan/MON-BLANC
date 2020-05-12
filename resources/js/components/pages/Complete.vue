<template>
  <div class="container">
    <vue-typer
      :repeat="0"
      :type-delay="100"
      text="This is your story.|"
      style="white-space:pre-line; word-wrap:break-word;"
      class="typer"
    ></vue-typer>
    <p>あなたの小説が完成しました。</p>

    <v-row align="center" justify="center">
      <router-link
        :to="{
                    name: 'ReadPaper',
                    params: {
                        hero_id: PaperNovelData.hero_id,
                        paper_novel_id: PaperNovelData.id
                    }
                }"
      >
        <v-img :src="'img/books/' + HeroData.img_url" max-width="250px"></v-img>
      </router-link>
    </v-row>
    <p class="novelTitle">{{ PaperNovelData.title }}</p>

    <!-- ボタンたち -->
    <div class="buttons">
      <!-- <router-link
        v-if="$store.state.login"
        :to="{
                        name: 'Profile',
                        params: { user_name: loginUser.user_name }
                    }"
        id="mypage"
      >
        <v-btn class="mypage-btn btn">マイページ</v-btn>
      </router-link>-->
      <v-btn class="mypage-btn btn" @click="$router.go(-1)">編集へ戻る</v-btn>
      <router-link
        :to="{
                    name: 'ReadPaper',
                    params: {
                        hero_id: PaperNovelData.hero_id,
                        paper_novel_id: PaperNovelData.id
                    }
                }"
      >
        <v-btn class="read-btn btn">投稿を読む</v-btn>
      </router-link>
      <router-link :to="{ name: 'SelectHero' }">
        <v-btn class="top-btn btn">TOPへ戻る</v-btn>
      </router-link>
    </div>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";

// Vueの処理
export default {
  components: {},
  data() {
    return {
      PaperNovelData: ""
    };
  },

  created() {
    // 小説のデータを取得
    this.showNovel();
  },
  beforeMount() {},
  mounted() {},
  computed: {
    ...mapGetters(["HeroData"])
  },
  methods: {
    //API叩いてマッチした主人公データを取得
    ...mapActions(["fetchHeroData"]),
    //ペーパーノベルの情報を取得
    showNovel: function() {
      axios
        .get("api/fetch/paper_novel/" + this.$route.params.user_paper_order)
        .then(res => {
          this.PaperNovelData = res.data;
          console.log(this.PaperNovelData);
          //主人公データを取得
          this.fetchHeroData(this.PaperNovelData.hero_id);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
.container {
  margin: 0 auto;
  text-align: center;
}
.content {
  margin: 10% auto;
  text-align: center;
}
.icon {
  width: 100px;
  cursor: pointer;
  position: fixed;
}
.vue-typer,
.typer {
  font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
    "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
  font-size: 30px;
}
.novelTitle {
  margin: 1em;
}

/* ボタン類 */
.buttons {
  margin: 2em;
}
.btn {
  margin: 0.5em 0.2em;
  padding: 8px;
  border-radius: 14px;
  text-align: center;
  cursor: pointer;
  font-weight: bold;
}
.mypage-btn {
  background-color: #c9eff5 !important;
  color: #000;
}
.mypage-btn:hover {
  background-color: rgb(183, 239, 247) !important;
}

.read-btn {
  background-color: #ffe8ae !important;
  color: #000;
}
.read-btn:hover {
  background-color: rgb(250, 220, 143) !important;
}

.top-btn {
  background-color: #f2f2f2 !important;
  color: #000;
}
.top-btn:hover {
  background-color: rgb(255, 255, 255) !important;
}
</style>
