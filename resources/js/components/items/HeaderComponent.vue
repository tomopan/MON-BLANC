<template>
    <v-app-bar>
        <v-col cols="3" class="spn">
            <router-link :to="{ name: 'Top' }" style="text-decoration: none">
                <v-btn id="pen" icon>
                    <v-avatar size="30">
                        <img :src="'/img/header/writing.png'" alt="pen" />
                    </v-avatar>
                </v-btn>
            </router-link>

            <!-- Find Storyへのリンク -->
            <router-link :to="{ name: 'FindStory' }">
                <v-btn id="books" icon>
                    <v-avatar tile size="30">
                        <img :src="'/img/header/frame.png'" alt="frame" />
                    </v-avatar>
                </v-btn>
            </router-link>

            <!-- Meet Storyへのリンク -->
            <router-link :to="{ name: 'MeetStory' }">
                <v-btn id="meet" icon>
                    <v-avatar tile size="30">
                        <img :src="'/img/header/reading.png'" alt="read" />
                    </v-avatar>
                </v-btn>
            </router-link>
        </v-col>
        <v-spacer class="nav"></v-spacer>
        <v-spacer class="nav"></v-spacer>
        <v-spacer class="nav"></v-spacer>

        <v-col class="d-flex justify-space-around center">
            <router-link
                :to="{ name: 'Top' }"
                style="text-decoration: none"
                id="logo"
            >
                <v-toolbar-title floating="true">
                    <img
                        :src="'/img/header/logo.png'"
                        width="100%"
                        class="logo"
                        alt="logo"
                    />
                </v-toolbar-title>
            </router-link>
        </v-col>

        <!-- マイページ -->
        <v-col cols="3" class="right spn">
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
                        <img
                            :src="'/img/header/mypage.png'"
                            alt="mypage"
                            v-if="$store.state.login"
                        />
                    </v-avatar>
                </v-btn>
            </router-link>

            <!-- ログインボタン -->
            <v-avatar v-if="!$store.state.login" tile size="30">
                <v-icon @click="toggleLoginModal" color="#000"
                    >mdi-login</v-icon
                >
            </v-avatar>
            <LoginModal />
        </v-col>
        <!-- ログアウトボタン -->
        <!-- <v-avatar tile size="30">
    <v-icon @click="logout" color="#000">mdi-logout</v-icon>
    </v-avatar> -->
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

.theme--light.v-app-bar.v-toolbar.v-sheet {
    background-color: #fff;
    position: relative;
    height: 120px !important;
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
    /* box-shadow: none; */
    /* background-color: #ffe5cc; */
    flex: none;
}

.v-btn {
    text-decoration: none;
}

.nav,
.space {
    display: none;
}

.right {
    display: flex;
    flex-direction: row-reverse;
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
