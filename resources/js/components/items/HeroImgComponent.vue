<template>
   <v-container class="pa-4 text-center">
      <v-row class="fill-height" align="center" justify="center">
         <div v-for="(hero, id) in heroes" :key="id">
         <router-link :to="{name:'Hero'}">
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
         <router-view @alert="alert"></router-view>
      </v-row>
   </v-container>

</template>


<script>
export default {
   props:{
      heroes:{
         type:Array
      },
   },

   data: () => ({
      hero_id:""
   }),
   created() {
      this.hero_id = this.heroes.id
      console.log(this.hero_id)
   },
   methods: {
       alert: function (msg) {
         alert(msg)
      }
   }
}
</script>

<style scoped>
.v-card {
   transition: opacity .4s ease-in-out;
}

.v-card:not(.on-hover) {
   opacity: 1;
}

.show-btns {
   color: rgba(255, 255, 255, 1) !important;
}
</style>