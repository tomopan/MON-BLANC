<template>
    <div>
        <v-app-bar>
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }">
                <v-btn icon>
                    <img :src="'/img/header/pen.png'" width="30" alt="logo">
                </v-btn>
            </router-link>
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }">
                <v-btn icon>
                    <img :src="'/img/header/books.png'" width="30" alt="logo">
                </v-btn>
            </router-link>

            <v-spacer></v-spacer>
            <router-link :to="{ name: 'Top' }" style="text-decoration: none">
                <v-toolbar-title floating="true">
                    <img :src="'/img/header/logo.png'" width="300" class="logo" alt="logo">
                </v-toolbar-title>
            </router-link>

            <v-spacer></v-spacer>

            <!-- マイページ -->
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }">
                <v-btn icon>
                    <img :src="'/img/header/mypage.png'" width="30" alt="logo">
                </v-btn>
            </router-link>
                <v-btn icon>
                    <v-icon @click="logout" color="#000">mdi-logout</v-icon>
                </v-btn>

                <img :src="'/img/header/line.png'" width="100%" id="line">
        </v-app-bar>
    </div>
</template>
<script>
// インポート
import { mapActions, mapGetters } from "vuex";


export default {
    
    data() {
        return {
        };
    },
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
    padding-top: 20px;
}

#line{
    position: absolute;
    top: 1px;
    bottom: 0;
    left: 0;
}

.v-toolbar{
    box-shadow: none;
}

.v-btn{
    text-decoration: none;
}


</style>