<template>
   <router-link :to="{name:'Hero'}">
   <v-container class="pa-4 text-center">
      <v-row class="fill-height" align="center" justify="center">
         <template v-for="(item, i) in items">
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
                  :src="item.img"
                  height="400px"
               
               >
                  <v-card-title class="title white--text">
                     <v-row
                     class="fill-height flex-column"
                     justify="space-between"
                     >
                     <p class="mt-4 subheading text-left">{{ item.title }}</p>

                     <div>
                        <p class="ma-0 body-1 font-weight-bold font-italic text-left">
                           {{ item.text }}
                        </p>
                        <p class="caption font-weight-medium font-italic text-left">
                           {{ item.subtext }}
                        </p>
                     </div>

                     <div class="align-self-center">
                        <v-btn
                           v-for="(icon, index) in icons"
                           :key="index"
                           :class="{ 'show-btns': hover }"
                           color="transparent"
                           icon
                        >
                           <v-icon
                           :class="{ 'show-btns': hover }"
                           color="transparent"
                           >
                           {{ icon }}
                           </v-icon>
                        </v-btn>
                     </div>
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
   data: () => ({
      icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
      items: [
      {
         title: 'New Releases',
         text: "It's New Release Friday",
         subtext: 'Newly released songs. Updated daily.',
         img:'https://assets.st-note.com/production/uploads/images/17220311/rectangle_large_type_2_e0050b10549e41bb8deb5a3d00e732d4.jpeg?fit=bounds&format=jpeg&quality=45&width=960',
      }
      ],
      hero_id:1,
   }),
   created:function(){
      this.$parent.hero_id = this.hero_id
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