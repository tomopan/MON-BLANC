<template>
<!-- <router-link :to="{name:'Hero'}"> -->
  <v-container class="pa-4 text-center">
    <v-row class="fill-height" align="center" justify="center">
    <HeroImgComponent/>
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
  <!-- </router-link> -->
</template>


<script>
import HeroImgComponent from "../items/HeroImgComponent.vue";

  export default {
    components: {
    HeroImgComponent
    },
    data: () => ({
      icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
      items: [
        {
          title: 'New Releases',
          text: "It's New Release Friday",
          subtext: 'Newly released songs. Updated daily.',
          img: 'https://papers.co/wallpaper/papers.co-ax64-her-film-poster-red-illustration-art-36-3840x2400-4k-wallpaper.jpg',
        },
        {
          title: 'Rock',
          text: 'Greatest Rock Hits',
          subtext: 'Lose yourself in rock tunes.',
          img: 'https://designrfix.com/wp-content/uploads/2011/01/photoshop-tuts-2010-nov-11.jpg',
          
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRMefmG-FwwVKeBuprwTUYbeOFwZS2tZR5zP29nT7gnM1nAG09y',
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://66.media.tumblr.com/13673c2bdc2d94ec6978408ef4f91e0b/2788a3b56f1ebfba-10/s1280x1920/8e777b9dd7c069aa49019604180c239d887cc4f4.jpg',
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://up.gc-img.net/post_img_web/2017/02/c552931232c708fbdb8077b6f0b2ef50_5434.jpeg',
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://i.ebayimg.com/00/s/MTUzMVgxMDk3/z/9yEAAOSwMNxXWb10/$_1.JPG',
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://up.gc-img.net/post_img/2017/02/hiN99zAVtpsI8ij_3Ocwd_27.jpeg',
        },
        {
          title: 'Mellow Moods',
          text: 'Ambient Bass',
          subtext: 'Chill beats to mellow you out.',
          img: 'https://www.kinokuniya.co.jp/images/goods/ar2/web/imgdata2/large/48664/4866471050.jpg',
        },
        
      ],
      transparent: 'rgba(255, 255, 255, 0)',
    }),
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


