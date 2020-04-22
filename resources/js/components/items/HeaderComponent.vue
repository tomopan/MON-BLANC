<template>
        <v-app-bar>
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }" id="pen">
                <v-btn icon>
                    <v-avatar tile size="30">
                        <img :src="'/img/header/pen2.png'" alt="pen">
                    </v-avatar>
                </v-btn>
            </router-link>
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }" id="books">
                <v-btn icon>
                    <v-avatar tile size="30">
                        <img :src="'/img/header/books.png'" alt="books">
                    </v-avatar>
                </v-btn>
            </router-link>
            <v-spacer class="nav"></v-spacer>
            <v-spacer class="nav"></v-spacer>
            <v-spacer class="nav"></v-spacer>

            <v-spacer></v-spacer>

            <router-link :to="{ name: 'Top' }" style="text-decoration: none" id="logo">
                <v-toolbar-title floating="true">
                    <img :src="'/img/header/logo.png'" width="100%" class="logo" alt="logo">
                </v-toolbar-title>
            </router-link>

            <v-spacer></v-spacer>

            <div class="nav">
                <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
            </div>

            <!-- マイページ -->
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }" id="mypage">
                <v-btn icon>
                    <v-avatar tile size="30">
                        <img :src="'/img/header/mypage.png'" alt="mypage">
                    </v-avatar>
                </v-btn>
            </router-link>
                    <!-- <v-icon @click="logout" color="#000">mdi-logout</v-icon> -->

                <img :src="'/img/header/line.png'" id="line">
        </v-app-bar>
</template>
<script>
// インポート
import { mapActions, mapGetters } from "vuex";


export default {
    
    data: () => ({
      drawer: false,
    }),
    created(){
        this.getLoginUserData();
    },
    computed: {
    ...mapGetters(["loginUser"]),
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
    }
    }
</script>
<style scoped>
*:focus {
outline: none;
}

.theme--light.v-app-bar.v-toolbar.v-sheet{
    background-color: #fff;
    position:relative;
    height: 140px!important;
    padding-top: 1em;

}

#line{
    position: absolute;
    width: 100%;
    top: 1em;
    z-index: -1;
    left: 0;
}

.logo{
    max-width: 400px;
    margin: auto;
    height: auto;
}

.v-toolbar{
    box-shadow: none;
}

.v-btn{
    text-decoration: none;
}

.nav,.space{
    display: none;
}

@media screen and (max-width:415px){
/*画面幅が415pxまでの時*/
.logo{
    width: 200px;
}

#line{
    padding-top: 1em;
    top: 3em;
}

#pen,#mypage,#books{
    display: none;
}

.nav{
    display:inline;
}

.theme--light.v-app-bar.v-toolbar.v-sheet{
    padding-top: 0;
}
}

</style>