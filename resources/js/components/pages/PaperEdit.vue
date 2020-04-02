<template>
    <div>
        <p>ペーパー編集ページ</p>
        <br />

        <!-- タイトルペーパー -->

        <!-- タイトルペーパーここまで -->
        <router-link
            :to="{
                name: 'WriteTitle',
                param: { novel_id: novelData.novel_id }
            }"
        >
            <v-card
                class="title_card"
                style="height: 200px;width:400px"
                tile
                outlined
            >
                <p v-if="title_toggle" class="title_text">
                    {{ novelData.title }}
                </p>
                <p v-else class="title_text">タイトルを入力してください</p>
            </v-card>
        </router-link>

        <!-- ペーパー表示 -->
        <v-container class="grey lighten-5">
            <v-row>
                <v-col v-for="(paper, i) in papers" :key="i" md="4">
                    <v-card style="height: 200px;width:400px" tile outlined>
                        <p class="paper_text">{{ paper.text }}</p>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>

        <!-- ペーパー追加ボタン -->
        <router-link
            :to="{
                name: 'AddPaper',
                params: { novel_id: $route.params.novel_id }
            }"
        >
            <v-btn class="mx-2">
                <v-icon dark>mdi-plus</v-icon>
            </v-btn>
        </router-link>
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート

// Vueの処理
export default {
    components: {},
    data() {
        return {
            //showNovel()のデータ格納
            novelData: "",
            //showPapers()のデータ格納
            papers: "",
            //titleの判定
            title_toggle: false,
            //UI用
            justify: ["start", "center", "end", "space-around", "space-between"]
        };
    },

    created() {
        this.showNovel();
        this.showPapers();
    },
    methods: {
        //小説の情報を取得
        showNovel: function() {
            axios
                .get("api/get/novel/" + this.$route.params.novel_id)
                .then(res => {
                    console.log(res);
                    this.novelData = res.data;
                    if (this.novelData.title) this.title_toggle = true;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        //小説のペーパーを取得
        showPapers: function() {
            axios
                .get("api/get/papers/" + this.$route.params.novel_id)
                .then(res => {
                    console.log(res);
                    this.papers = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
.paper_text {
    writing-mode: vertical-rl;
    margin: auto;
    position: absolute;
    right: 0;
}
/* .title_card {
} */
.title_text {
    writing-mode: vertical-rl;
    margin: 0 auto;
    margin-top:5%;
}
</style>
