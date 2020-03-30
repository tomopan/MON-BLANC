<template>
  <div>
    <h1>執筆中ページ</h1>
    <!-- {{writingEpisodes}} -->
    <li v-for="writingNovel in writingNovels" :key="writingNovel.id">{{writingNovel.title}}</li>
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
            return obj;
          });
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