<template>
    <v-container class="text-center">
        <vue-typer
            repeat
            text="Meet Storeis"
            style="font-size:30px"
        ></vue-typer>
        <br />
        <v-icon @click="getRandom">
            mdi-reload
        </v-icon>
        <v-row class="fill-height" align="center" justify="center">
            <div v-for="(novel, i) in randomNovels" :key="i">
                <v-col>
                    <v-img :src="flameImgUrl[i]" width="350px">
                        <span class="text">{{ novel.first_sentence }}</span>
                    </v-img>
                </v-col>
            </div>
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
