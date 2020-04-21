<template>
    <div class="container">
        <p>あなたの小説が完成しました！</p>
            <router-link
                :to="{
                    name: 'EditPaperNovel',
                    params: {
                        user_paper_order:$route.params.user_paper_order
                    }
                }"
            >
                <v-img
                    class="icon"
                    src="img/write-page/continue.png"
                >
                </v-img>
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

        };
    },

    created() {
        //主人公データを取得
        this.fetchHeroData(this.$route.params.hero_id);

    },
    beforeMount(){

    },
    mounted(){

    },
    computed: {
        ...mapGetters(["HeroData"]),
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
    }
};

</script>

<style scoped>
.container{
    margin: 0 auto;
    text-align: center;
}
.icon{
    width: 100px;
}
</style>
