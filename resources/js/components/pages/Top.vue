<template>
<!-- <router-link :to="{name:'Hero'}"> -->
  <v-container class="pa-4 text-center">
    <v-row class="fill-height" align="center" justify="center">
    <HeroImgComponent 
      :heroes="heroes"
    />
    </v-row>
  </v-container>
  <!-- </router-link> -->
</template>


<script>
import HeroImgComponent from "../items/HeroImgComponent.vue";

  export default {
    components: {
    HeroImgComponent
    },

    data: () => ({
      heroes:[],
      test:"test"
    }),

    created() {
      //主人公を表示
      this.showHeroes();
    },

    methods: {
      //主人公の情報を取得
      showHeroes:function(){
        axios
            .get("api/get/hero")
            .then(res => {
              console.log(res.data)
              this.heroes.push(res.data[0])
            })
            .catch(err => {
              console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
      },
  }
  }
</script>

<style scoped>
.v-card {
  transition: opacity .4s ease-in-out;
}

.v-card:not(.on-hover) {
  opacity: 0.8;
}

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
}
</style>


