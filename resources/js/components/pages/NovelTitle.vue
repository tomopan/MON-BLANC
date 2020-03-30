<template>
  <div>
    <p>小説を作成</p>

    <!-- 主人公の名前を表示 -->
    <p>{{hero.hero_description}}</p>

    <!-- タイトル入力 -->
    <v-form>
      <v-text-field label="小説タイトル" id="novel_title" v-model="novelTitlePost.title"></v-text-field>

      <!--保存ボタン -->
      <!-- <router-link :to="{name:'Write',params:{hero_id:$route.params.hero_id,novel_id:postNovelId}}"> -->
      <v-btn color="primary" id="save" dark @click="saveNovelTitle">保存して第1話を書く</v-btn>
      <!-- </router-link> -->
    </v-form>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// Vueの処理
export default {
  components: {},
  data() {
    return {
      //タイトルとテキストを格納
      novelTitlePost: {},
      postNovelId: null,
      hero: {}
    };
  },

  created() {
    this.showHero();
  },
  methods: {
    //小説のタイトルを保存
    saveNovelTitle: function() {
      axios
        .post(
          "api/post/noveltitle/" + this.$route.params.hero_id,
          this.novelTitlePost
        )
        .then(res => {
          console.log(res.data);
          // console.log(res.data.id);
          this.$router.push({
            name: "Write",
            params: {
              hero_id: this.$route.params.hero_id,
              novel_id: res.data.id
            }
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //API叩いてマッチした主人公データを取得
    showHero: function() {
      axios
        .get("api/get/hero/" + this.$route.params.hero_id)
        .then(res => {
          console.log(res.data);
          this.hero = res.data[0];
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    }
  }
};
</script>

<style scoped>
</style>

