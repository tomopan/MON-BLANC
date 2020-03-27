<template>
<div>
    <h1>執筆中ページ</h1>
  <!-- {{writingEpisodes}} -->
    <li v-for="writingEpisode in writingEpisodes" :key="writingEpisode.novel_id">
      小説No.:{{writingEpisode.novel_id}}/エピソードタイトル:{{ writingEpisode.episode_title }}
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
      writingEpisodes:[]
    };
  },

  created() {
    this.showWritingEpisode();
  },
  methods: {
    showWritingEpisode:function(){
    //Episodesテーブルから情報を取得
        axios
        .get("api/get/episode/writing")
        .then(res => {
          //配列に格納
          this.writingEpisodes = res.data.map(data => {
            const obj = {}; 
             obj['novel_id'] = data.novel_id;
             obj['episode_title'] = data.episode_title;
             return obj;
            })
          console.log(this.writingEpisodes);
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