<template>
  <div>
    <h1>公開中の小説</h1>
    <!-- {{writedNovels}} -->
    <li v-for="(writedNovel,i) in writedNovels" :key="i">
      <router-link
        :to="{name:'Read',params:{hero_id:writedNovel.hero_id,novel_id:writedNovel.novel_id}}"
      >{{writedNovel.title}}</router-link>
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
      writedEpisodes: [],
      writedNovels: []
    };
  },

  created() {
    // this.showWritedEpisode();
    this.showWritedNovel();
  },
  methods: {
    showWritedNovel: function() {
      axios
        .get("api/get/novel/writed")
        .then(res => {
          console.log(res);
          this.writedNovels = res.data.map(data => {
            const obj = {};
            obj["title"] = data.title;
            obj["hero_id"] = data.hero_id;
            obj["novel_id"] = data.id;
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