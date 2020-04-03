<template>
    <v-container>
        <!-- ユーザープロフィール/実装ではDBから取得してくる -->
        <v-row>
            <v-col>
                <p>{{ userData.name }} さんのマイページです</p>
                <!-- <p>フォロワー：{{userData.follower_count}}人/フォロー：{{userData.follow_count}}人</p> -->
            </v-col>
            <v-col>
                <v-avatar size="100"> </v-avatar>
            </v-col>
        </v-row>
        <!-- 公開/非公開のコンポーネント切り替え -->
        <v-tabs background-color="transparent" color="basil" grow>
            <router-link :to="{ name: 'Writedbooks' }">
                <v-tab>
                    <p style="color:black">公開中</p>
                </v-tab>
            </router-link>
            <router-link :to="{ name: 'Writingbooks' }">
                <v-tab>
                    <p style="color:black">非公開</p>
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

// Vueの処理
export default {
    components: {},
    data() {
        return {
            userData: [],
            openNovels: [],
            closeNovels: []
        };
    },

    created() {
        this.showUser();
        // this.showOpenNovel();
        // this.showCloseNovel();
        // this.showWritedNovel();
    },
    methods: {
        //userデータ取得
        showUser: function() {
            axios
                .get("api/get/user")
                .then(res => {
                    this.userData = res.data;
                    console.log(this.userData);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped></style>
