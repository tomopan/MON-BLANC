<template>
  <v-container class="pa-4 text-center">
    <v-row class="fill-height" align="center" justify="center">
       <v-container class="pa-4 text-center">
      <v-row class="fill-height" align="center" justify="center">
         <div v-for="(hero, id) in heroes" :key="id">
         <router-link :to="{name:'Hero',params:{hero_id:hero.id,url:hero.img_url}}">
         <v-col
            :key="id"
            cols="12"
            md="3"
         >
            <v-hover v-slot:default="{ hover }">
               <v-card
               :elevation="hover ? 12 : 2"
               :class="{ 'on-hover': hover }"
               >
               <v-img
                  :src="hero.img_url"
                  height="400px"
                  width="400px"
               >
                  <v-card-title class="title white--text">
                     <v-row
                     class="fill-height flex-column"
                     justify="space-between"
                     >
                     <p class="mt-4 subheading text-left" style="color:white">主人公ID : {{hero.id}}</p>
                     <p class="mt-4 subheading text-left" style="color:white">名前 : {{hero.hero_description}}</p>
                     </v-row>
                  </v-card-title>
               </v-img>
               </v-card>
            </v-hover>
         </v-col>
         </router-link>
         </div>
         <!-- <router-view @alert="alert"></router-view> -->
      </v-row>
   </v-container>

    </v-row>
  </v-container>
  <!-- </router-link> -->
</template>


<script>

  export default {
    components: {

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
              this.heroes = res.data;
              console.log(this.heroes)
            })
            .catch(err => {
              console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
            })
      },
      //テスト
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


