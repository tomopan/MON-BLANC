<template>
    <v-container class="pa-4 text-center">
        <v-row class="fill-height" align="center" justify="center">
            <!-- choice your charactorここから -->
            <v-container class="pa-4 text-center">
                <vue-typer
                    :repeat="0"
                    text="choice your charactor"
                    style="font-size:30px"
                ></vue-typer>
                <div class="wrap">
                        <TopBase />
                </div>
                    <!-- <v-row class="fill-height" align="center" justify="center">
                        <div v-for="(hero_img, id) in hero_imgs" :key="id">
                            <router-link
                                :to="{
                                    name: 'WriteFirstSentence',
                                    params: { hero_id: hero_img.id },
                                }"
                            >
                                <v-img
                                    :src="hero_img.url"
                                    width="300px"
                                >
                                </v-img>
                            </router-link>
                        </div>
                    </v-row> -->
            </v-container>
        </v-row>
    </v-container>
    <!-- </router-link> -->
</template>
<script>
import TopBase from "./TopBase.vue";

export default {

    components: {
        TopBase
    },

    data: () => ({
        heroes: []
    }),

    created() {
        //主人公を表示
        this.showHeroes();
    },

    methods: {
        //主人公の情報を取得
        showHeroes: function() {
            axios
                .get("api/get/hero")
                .then(res => {
                    this.heroes = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

a:hover {
    text-decoration: none;
}

.v-card {
    transition: opacity 0.4s ease-in-out;
    color: #333333;
}

.v-card:not(.on-hover) {
    opacity: 0.8;
}

p {
    font-family: "Lao MN", "serif";
}

.show-btns {
    color: rgba(255, 255, 255, 1) !important;
}


.stage{
    width: 100%;
    height: 400px;
}

</style>
