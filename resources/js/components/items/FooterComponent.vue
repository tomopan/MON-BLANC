<template>
  <v-bottom-navigation fixed absolute hide-on-scroll>
    <v-btn value="write">
      <router-link :to="{ name: 'SelectHero' }" style="text-decoration: none">
        <v-avatar tile size="30" value="write">
          <img :src="'/img/header/write.png'" alt="write" />
        </v-avatar>
      </router-link>
    </v-btn>

    <v-btn value="favorites">
      <router-link :to="{ name: 'FindStory'}">
        <v-avatar tile size="30">
          <img :src="'/img/header/read.png'" alt="read" />
        </v-avatar>
      </router-link>
    </v-btn>

    <v-btn value="nearby">
      <router-link :to="{ name: 'Bookmark' }">
        <v-avatar tile size="30">
          <img :src="'/img/header/books.png'" alt="books" />
        </v-avatar>
      </router-link>
    </v-btn>

    <v-btn value="mypage" v-if="$store.state.login">
      <router-link
        v-if="$store.state.login"
        :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }"
        id="mypage"
      >
        <v-avatar tile size="30">
          <img :src="'/img/header/mypage.png'" alt="mypage" />
        </v-avatar>
      </router-link>
    </v-btn>
    <v-btn value="mypage" @click="$store.state.drawerLoginModal=true" v-else>
      <v-avatar tile size="30">
        <img :src="'/img/header/mypage.png'" alt="mypage" />
      </v-avatar>
    </v-btn>
  </v-bottom-navigation>
</template>
<script>
// インポート
import { mapActions, mapGetters } from "vuex";
import LoginModal from "./LoginModal";

export default {
  components: {
    LoginModal
  },
  data: () => ({
    drawer: false,
    loginDialog: false
  }),
  created() {
    this.getLoginUserData();
  },
  computed: {
    ...mapGetters(["loginUser"])
  },
  methods: {
    logout: function() {
      axios
        .post("logout")
        .then(res => {
          location.href = "/";
        })
        .catch(err => console.log(err));
    },
    //ログインしているユーザーの情報
    ...mapActions(["getLoginUserData"]),
    // loginモーダルの開閉
    ...mapActions(["toggleLoginModal"])
  }
};
</script>
<style scoped>
v-bottom-navigation {
  display: none;
  bottom: 0;
  width: 100%;
}

a {
  text-decoration: none;
}

.v-item-group.v-bottom-navigation {
  display: none;
}

@media screen and (max-width: 415px) {

  .v-item-group.v-bottom-navigation {
    display: flex;
  }
}
</style>