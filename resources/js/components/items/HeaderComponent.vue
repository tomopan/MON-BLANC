<template>
    <div>
        <v-app-bar>
            <v-spacer></v-spacer>
            <router-link :to="{ name: 'Top' }" style="text-decoration: none">
                <v-toolbar-title floating="true">
                    <span style="font-size:30px;color:#A39362 ;">Mon Blan</span>
                </v-toolbar-title>
            </router-link>

            <v-spacer></v-spacer>

            <!-- マイページ -->
            <router-link :to="{ name: 'Profile',params:{user_name:loginUser.user_name} }">
                <v-btn icon>
                    <v-icon>mdi-home</v-icon>
                </v-btn>
            </router-link>
                <v-btn icon>
                    <v-icon @click="logout">mdi-logout</v-icon>
                </v-btn>
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

.v-btn{
    text-decoration: none;
}


</style>