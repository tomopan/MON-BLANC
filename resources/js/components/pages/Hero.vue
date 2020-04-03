<template>
    <div id="container">
        <!-- 主人公の画像 -->
        <div class="hero_img">
            <v-img height="700px" :src="hero.img_url">
                <!-- <v-card-title>
                    <v-row justify="space-between"> </v-row>
                </v-card-title> -->
            </v-img>
        </div>
        <!-- ロゴ -->
        <div class="logo_img">
            <img width="900px" src="img/monblan_logo.png" />
        </div>
        <!-- 主人公のテキスト -->
        <div class="hero_text">
            <div style="color:black;font-size:20px;">
                <p>
                    Name　：
                    {{ hero.hero_name }}
                </p>
                <br />
                <br />
                <p>Born in {{ hero.hero_birth }}</p>
            </div>
        </div>
        <!-- ボタン -->
        <div class="btns">
            <!-- 読むボタン -->
            <router-link
                :to="{
                    name: 'ReadFirst',
                    params: { hero_id: $route.params.hero_id }
                }"
            >
                <v-btn class="ma-2" tile outlined color="">
                    <v-icon left>mdi-book-open-page-variant</v-icon>読む
                </v-btn>
            </router-link>

            <!-- 書くボタン -->
            <router-link
                :to="{
                    name: 'WriteFirstSentence',
                    params: { hero_id: $route.params.hero_id }
                }"
            >
                <v-btn class="ma-2" tile outlined color="">
                    <v-icon left>mdi-pencil</v-icon>書く
                </v-btn>
            </router-link>
        </div>
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
    components: {},

    data() {
        return {
            hero: {},
            novels: []
        };
    },
    watch: {
        // ルートが変更されたらこのメソッドを再び呼び出します
        $route: "showHero"
    },
    created() {
        //hero_idに遷移した主人公idを代入
        this.showHero();
        this.showNovels();
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        showHero: function() {
            axios
                .get("api/get/hero/" + this.$route.params.hero_id)
                .then(res => {
                    console.log(res.data);
                    this.hero = res.data[0];
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        //主人公に書かれている小説のタイトルを表示
        showNovels: function() {
            axios
                .get("api/get/novels/" + this.$route.params.hero_id)
                .then(res => {
                    console.log(res.data);
                    this.novels = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
#container {
    display: grid;
    grid-template-rows: 1fr 1fr 1fr 1fr;
    grid-template-columns: 1fr 1fr 1fr;
}
.hero_img {
    grid-row: 1 / 5;
    grid-column: 3 / 4;
}
.logo_img {
    grid-row: 1 / 3;
    grid-column: 1 / 3;
}
.hero_text {
    grid-row: 3 / 4;
    grid-column: 1 / 3;
    text-align: right;
    margin-right: 10%;
}
.btns {
    grid-row: 4 / 5;
    grid-column: 1 / 3;
    text-align: right;
    margin-right: 10%;
}
</style>
