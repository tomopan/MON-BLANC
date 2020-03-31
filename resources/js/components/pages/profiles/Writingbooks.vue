<template>
  <div>
    <h1>執筆中ページ</h1>
    <li v-for="(writingNovel,i) in writingNovels" :key="i">
      {{writingNovel.title}}
      <v-btn class="ma-2" tile outlined color="success" @click="openNovel(i,writingNovel.id)">公開する</v-btn>
    </li>
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
      writingNovels: []
    };
  },

  created() {
    this.showWritingNovel();
  },
  methods: {
    showWritingNovel: function() {
      axios
        .get("api/get/novel/writing")
        .then(res => {
          console.log(res);
          this.writingNovels = res.data.map(data => {
            const obj = {};
            obj["title"] = data.title;
            obj["id"] = data.id;
            return obj;
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    openNovel: function(i,novel_id) {
      axios
        .post("api/update/novel/open/" + novel_id)
        .then(res => {
          console.log(this.writingNovels);
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
      // 配列からも削除してデータバインディング
      this.writingNovels.splice(i, 1);
    }
  }
};
</script>

<style scoped>
</style>