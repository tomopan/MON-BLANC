<template>
    <v-container>
        <!-- ユーザープロフィール/実装ではDBから取得してくる -->
        <v-row>
            <v-col>
                <p>{{ loginUser.name }} さんのマイページです</p>
                <!-- <p>フォロワー：{{userData.follower_count}}人/フォロー：{{userData.follow_count}}人</p> -->
            </v-col>
            <v-col>
                <v-avatar size="100"> </v-avatar>
            </v-col>
        </v-row>
        <!-- 公開/非公開のコンポーネント切り替え -->
        <v-tabs background-color="transparent" color="basil" grow>
            <router-link :to="{ name: 'PaperNovelOpened' }">
                <v-tab>
                    <p>公開中</p>
                </v-tab>
            </router-link>
            <router-link :to="{ name: 'PaperNovelClosed' }">
                <v-tab>
                    <p>非公開</p>
                </v-tab>
            </router-link>
            <router-link :to="{ name: 'MarkedText' }">
                <v-tab>
                    <p>マーカー</p>
                </v-tab>
            </router-link>
        </v-tabs>
        <router-view></router-view>

        <!-- 書いた小説を表示 -->
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";
// Vueの処理
export default {
    components: {},
    data() {
        return {
            openNovels: [],
            closeNovels: [],
        };
    },
    created() {
        this.getLoginUserData();
    },
    computed: {
        ...mapGetters(["loginUser"]),
    },
    methods: {
        //ログインしているユーザーの情報
        ...mapActions(["getLoginUserData"]),
    },
};
</script>

<style scoped>
*:focus {
outline: none;
}

p{
    color: #333;
}
a:hover{
    text-decoration: none;
}
</style>
