<template>
  <v-app-bar>
    <router-link :to="{ name: 'Top' }" style="text-decoration: none">
      <v-btn id="pen" icon>
        <v-avatar tile size="30">
          <img :src="'/img/header/pen2.png'" alt="pen" />
        </v-avatar>
      </v-btn>
    </router-link>

    <!-- Find Storyへのリンク -->
    <router-link :to="{ name: 'FindStory'}">
      <v-btn id="books" icon>
        <v-avatar tile size="30">
          <img :src="'/img/header/books.png'" alt="books" />
        </v-avatar>
      </v-btn>
    </router-link>

    <!-- Meet Storyへのリンク -->
    <router-link :to="{ name: 'MeetStory' }">
      <v-btn id="meet" icon>
        <v-icon color="#000">mdi-head-lightbulb-outline</v-icon>
      </v-btn>
    </router-link>

    <v-spacer class="nav"></v-spacer>
    <v-spacer class="nav"></v-spacer>
    <v-spacer class="nav"></v-spacer>

    <v-spacer></v-spacer>

    <router-link :to="{ name: 'Top' }" style="text-decoration: none" id="logo">
      <v-toolbar-title floating="true">
        <img :src="'/img/header/logo.png'" width="100%" class="logo" alt="logo" />
      </v-toolbar-title>
    </router-link>

    <v-spacer></v-spacer>

    <!-- マイページ -->
    <router-link
      v-if="$store.state.login"
      :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }"
      id="mypage"
    >
      <v-btn id="mypage" icon>
        <v-avatar tile size="30">
          <img :src="'/img/header/mypage.png'" alt="mypage" />
        </v-avatar>
      </v-btn>
    </router-link>

    <!-- ログインボタン -->
    <v-avatar tile size="30">
        <v-icon @click="toggleLoginModal" color="red">mdi-login</v-icon>
    </v-avatar>
    <LoginModal/>

    <!-- ログアウトボタン -->
    <v-avatar tile size="30">
    <v-icon @click="logout" color="#000">mdi-logout</v-icon>
    </v-avatar>
    <!-- ライン -->
    <img :src="'/img/header/line.png'" id="line" />
  </v-app-bar>
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
*:focus {
  outline: none;
}

.theme--light.v-app-bar.v-toolbar.v-sheet {
  background-color: #fff;
  position: relative;
  height: 140px !important;
  padding-top: 1em;
}

#line {
  position: absolute;
  width: 100%;
  top: 1em;
  z-index: -1;
  left: 0;
}

.logo {
  max-width: 400px;
  margin: auto;
  height: auto;
}

.v-toolbar {
  box-shadow: none;
}

.v-btn {
  text-decoration: none;
}

.nav,
.space {
  display: none;
}

@media screen and (max-width: 415px) {
  /*画面幅が415pxまでの時*/
  .logo {
    width: 200px;
  }

  #line {
    padding-top: 1em;
    top: 3em;
  }

  #pen,
  #mypage,
  #books,
  #meet {
    display: none;
  }

  .nav {
    display: inline;
  }

  .theme--light.v-app-bar.v-toolbar.v-sheet {
    padding-top: 0;
  }
}


</style>