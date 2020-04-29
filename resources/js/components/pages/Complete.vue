<template>
    <div class="container">
        <p>あなたの小説が完成しました！</p>
        <router-link
            :to="{
                name: 'EditPaperNovel',
                params: {
                    user_paper_order: $route.params.user_paper_order
                }
            }"
        >
            <v-img class="icon" src="img/write-page/continue.png"> </v-img>
        </router-link>

        <v-row align="center" justify="center">
            <router-link
                :to="{
                    name: 'ReadPaper',
                    params: {
                        hero_id: PaperNovelData.hero_id,
                        paper_novel_id: PaperNovelData.id
                    }
                }"
            >
                <v-img :src="HeroData.img_url" max-width="300px"></v-img>
            </router-link>
        </v-row>
        <p>{{ PaperNovelData.title }}</p>
    </div>
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
            PaperNovelData: ""
        };
    },

    created() {
        // 小説のデータを取得
        this.showNovel();
    },
    beforeMount() {},
    mounted() {},
    computed: {
        ...mapGetters(["HeroData"])
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
        //ペーパーノベルの情報を取得
        showNovel: function() {
            axios
                .get(
                    "api/fetch/paper_novel/" +
                        this.$route.params.user_paper_order
                )
                .then(res => {
                    this.PaperNovelData = res.data;
                    console.log(this.PaperNovelData);
                    //主人公データを取得
                    this.fetchHeroData(this.PaperNovelData.hero_id);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
.container {
    margin: 0 auto;
    text-align: center;
}
.content {
    margin: 0 auto;
    text-align: center;
}
.icon {
    width: 100px;
    cursor: pointer;
    position: fixed;
}
</style>
