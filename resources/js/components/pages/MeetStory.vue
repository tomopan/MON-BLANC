<template>
    <v-container class="text-center">
        <vue-typer
            :repeat="0"
            text="Meet Storeis"
            style="font-size:30px"
        ></vue-typer>
        <br />
        <br />
        <v-icon large @click="getRandom">
            mdi-reload
        </v-icon>
        <!-- カルーセルで表示 -->
        <v-row
            v-touch="{
                left: () => swipe('Left'),
                right: () => swipe('Right')
            }"
        >
            <v-carousel cycle height="700" show-arrows-on-hover hide-delimiters>
                <v-carousel-item v-for="(novel, i) in randomNovels" :key="i">
                    <v-sheet height="100%" color="white">
                        <v-row
                            height="100%"
                            class="fill-height"
                            align="center"
                            justify="center"
                        >
                            <router-link
                                :to="{
                                    name: 'ReadPaper',
                                    params: {
                                        hero_id: novel.hero_id,
                                        paper_novel_id: novel.id
                                    }
                                }"
                            >
                                <v-img :src="flameImgUrl[i]" width="350px">
                                    <span class="text">{{
                                        novel.first_sentence
                                    }}</span>
                                </v-img>
                            </router-link>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>
        </v-row>
    </v-container>
</template>
<script>
export default {
    components: {},

    data: () => ({
        flameImgUrl: [
            "img/flames/flame1.png",
            "img/flames/flame2.png",
            "img/flames/flame3.png",
            "img/flames/flame4.png"
        ],
        randomNovels: ""
    }),

    created() {
        this.getRandom();
    },

    methods: {
        getRandom: function() {
            axios
                .get("api/get/paper_novel/random")
                .then(res => {
                    console.log(res.data);
                    this.randomNovels = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        }
    }
};
</script>

<style scoped>
.text {
    writing-mode: vertical-rl;
    margin: auto;
    color: #333;
    font-size: 20px;
    height: 500px;
}
.flame_img {
    /* width: 300px; */
}
</style>
