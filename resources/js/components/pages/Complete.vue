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
            PaperNovelData:"",
        };
    },

    created() {
        // 小説のデータを取得
        this.showNovel();
        //主人公データを取得
        this.fetchHeroData(this.PaperNovelData.hero_id);
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
                    //タイトルの場合はtoggleをtrue
                    if (this.PaperNovelData.title) this.title_toggle = true;
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
.icon {
    width: 100px;
}
</style>
