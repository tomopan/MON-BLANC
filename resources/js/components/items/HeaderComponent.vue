<template>
  <v-app-bar>

      <router-link :to="{ name: 'FindStory' }" style="text-decoration: none" id="logo">
        <v-toolbar-title floating="true">
          <img :src="'/img/header/headerLogo.png'" class="logo" alt="logo" />
        </v-toolbar-title>
      </router-link>

      <!-- 書くページ（主人公選択）へのリンク -->
      <router-link :to="{ name: 'SelectHero' }">
        <div class="menuButton">
          <div>
              <img :src="'/img/header/write.png'" class="write" alt="write" />
          </div>
          <div>
              かく
          </div>
        </div>
      </router-link>

      <!-- タイムラインへのリンク -->
      <router-link :to="{ name: 'FindStory' }" style="text-decoration: none">
        <div class="menuButton">
          <div>
              <img :src="'/img/header/read.png'" class="read" alt="read" />
          </div>
          <div>
              よむ
          </div>
        </div>
      </router-link>

      <!-- 本棚へのリンク -->
      <router-link :to="{ name: 'Bookmark' }">
        <div class="menuButton">
          <div>
              <img :src="'/img/header/books.png'" class="books" alt="books" />
          </div>
          <div>
              ほんだな
          </div>
        </div>
      </router-link>

    <v-spacer></v-spacer>
    <!-- マイページ -->
    <div>
      <router-link
        v-if="$store.state.login"
        :to="{
                    name: 'Profile',
                    params: { user_name: loginUser.user_name }
                }"
        id="mypage"
      >
        <v-btn id="mypage" icon v-if="$store.state.login">
          <v-avatar tile size="30" v-if="$store.state.login">
            <img :src="'/img/header/mypage.png'" alt="mypage" v-if="$store.state.login" />
          </v-avatar>
        </v-btn>
      </router-link>
        <!-- ログインボタン -->
        <v-avatar v-if="!$store.state.login" tile size="30">
          <v-icon @click="toggleLoginModal" color="#000">mdi-login</v-icon>
        </v-avatar>
        <LoginModal />
      </div>

    <!-- ログアウトボタン -->
    <!-- <v-avatar tile size="30">
    <v-icon @click="logout" color="#000">mdi-logout</v-icon>
    </v-avatar>-->
    <!-- ライン -->
    <!-- <img :src="'/img/header/line.png'" id="line" /> -->
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

div{
  font-family: "Apple SD Gothic Neo", "serif";
  color: #000;
  font-size: 0.9em;
}

a{
  text-decoration: none;
}

.theme--light.v-app-bar.v-toolbar.v-sheet {
  background-color: #fff;
}

.logo {
  max-width: 180px;
  margin: 0 4em 0 3em;
  height: auto;
}

.menuButton{
  display: flex;
  flex-direction: column;
  align-items: center;
}

.menuButton:hover{
  opacity: 60%;
}

.write,.read,.books{
  height: 25px;
  margin: 0 2em .2em;
}

.v-toolbar {
  box-shadow: none;
  flex: none;
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
  #meet,
  .spn,
  .right {
    display: none !important;
  }

  .nav {
    display: inline;
  }

  .theme--light.v-app-bar.v-toolbar.v-sheet {
    padding-top: 0;
  }
}
</style>
<style>
@media screen and (max-width: 415px) {
  .v-toolbar__content {
    display: block !important;
  }
}
</style>
