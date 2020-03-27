<template>
<div>
    <h1>執筆済みページ</h1>
  <!-- {{writingEpisodes}} -->
    <li v-for="writedEpisode in writedEpisodes" :key="writedEpisode.novel_id">
      小説No.:{{writedEpisode.novel_id}}/エピソードタイトル:{{ writedEpisode.episode_title }}
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
      writedEpisodes:[]
    };
  },

  created() {
    this.showwritedEpisode();
  },
  methods: {
    showwritedEpisode:function(){
    //Episodesテーブルから情報を取得
        axios
        .get("api/get/episode/writed")
        .then(res => {
          //配列に格納
          this.writedEpisodes = res.data.map(data => {
            const obj = {}; 
             obj['novel_id'] = data.novel_id;
             obj['episode_title'] = data.episode_title;
             return obj;
            })
          console.log(this.writedEpisodes);
        })
        .catch(err => {
            console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜
        })
    }
  }
};
</script>

<style scoped>

</style>