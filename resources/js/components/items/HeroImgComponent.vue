<template>
   <router-link :to="{name:'Hero'}">
   <v-container class="pa-4 text-center">
      <v-row class="fill-height" align="center" justify="center">
         <template v-for="(hero, i) in heroes">
         <v-col
            :key="i"
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
         </template>
      </v-row>
   </v-container>
   </router-link>

</template>


<script>
export default {
   props:{
      heroes:{
         type:Array
      },
   },

   data: () => ({
      icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
      items: [
      {
         img:'https://assets.st-note.com/production/uploads/images/17220311/rectangle_large_type_2_e0050b10549e41bb8deb5a3d00e732d4.jpeg?fit=bounds&format=jpeg&quality=45&width=960',
      }
      ],
   }),
   created() {


   },
   methods: {

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