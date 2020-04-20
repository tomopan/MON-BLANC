<template>
    <v-container class="pa-4 text-center">
        <v-row class="fill-height" align="center" justify="center">
            <!-- choice your charactorここから -->
            <v-container class="pa-4 text-center">
                <p style="font-size:30px">choice your charactor</p>
                    <v-row class="fill-height" align="center" justify="center">
                        <div v-for="(hero_img, id) in hero_imgs" :key="id">
                            <router-link
                                :to="{
                                    name: 'SelectWrite',
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
                    </v-row>
            </v-container>


            <!-- read booksここから -->
            <v-container class="pa-4 text-center">
                <p style="font-size:30px">read books</p>
                <v-row class="fill-height" align="center" justify="center">
                    <div v-for="(hero, id) in heroes" :key="id">
                        <v-col :key="id">
                            <router-link
                                :to="{
                                    name: 'ReadFirst',
                                    params: { hero_id:hero.id },
                                }"
                            >
                                <v-img
                                    :src="hero.img_url"
                                    width="300px"
                                >
                                </v-img>
                            </router-link>
                        </v-col>
                    </div>
                </v-row>
            </v-container>
        </v-row>
    </v-container>
    <!-- </router-link> -->
</template>
<script>
export default {
    components: {},

    data: () => ({
        hero_imgs:[
            {id:1,url:'img/charactors/akira.png'},
            {id:2,url:'img/charactors/lisa.png'},
            {id:3,url:'img/charactors/ami&karin.png'},
            {id:4,url:'img/charactors/mari.png'},
            {id:6,url:'img/charactors/rui.png'},
        ],
        heroes: [],

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
                    console.log(res.data);
                    this.heroes = res.data;
                    console.log(this.heroes);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
        //テスト
    }
};
</script>

<style scoped>
*:focus {
outline: none;
}

a:hover{
    text-decoration: none;
}

.v-card {
    transition: opacity 0.4s ease-in-out;
    color: #333333;
}

.v-card:not(.on-hover) {
    opacity: 0.8;
}

p{
    font-family: 'Lao MN','serif';
}

.show-btns {
    color: rgba(255, 255, 255, 1) !important;
}


</style>
