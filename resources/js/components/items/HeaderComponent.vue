
<template>
  <div>
    <v-app-bar
      color="deep-purple accent-4"
      dense
      dark
    >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>AdultVibes</v-toolbar-title>

      <v-spacer></v-spacer>

      <router-link :to="{ name: 'Top'}">
        <p style="color:white"> TOP</p>
      </router-link>
      /
      <router-link :to="{ name: 'Hero'}">
        <p style="color:white"> 主人公</p>
      </router-link>
      /
      <router-link :to="{ name: 'HeroDetail'}">
        <p style="color:white"> 主人公紹介</p>
      </router-link>
      /
      <router-link :to="{ name: 'Episodes'}">
        <p style="color:white"> 目次</p>
      </router-link>
      /
      <router-link :to="{ name: 'Read'}">
        <p style="color:white"> 読書</p>
      </router-link>
      /
      <router-link :to="{ name: 'Write'}">
        <p style="color:white"> 執筆</p>
      </router-link>


    <!-- マイページ -->
    <router-link :to="{ name: 'Profile'}">
        <v-btn icon>
            <v-icon>mdi-home</v-icon>
        </v-btn>
    </router-link>
    
    <!-- メニューアイコン -->
    <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item
            v-for="n in 5"
            :key="n"
            @click="() => {}"
          >
            <v-list-item-title>Option {{ n }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>