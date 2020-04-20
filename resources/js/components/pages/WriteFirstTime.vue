<template>
        <div class="select-area" >
            <p>初めて小説を書く</p>
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

</style>
