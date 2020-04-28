<template>
    <v-container class="pa-4 text-center">
        <!-- 主人公から探す -->
        <div class="hero-find">
            <vue-typer
                :repeat="0"
                text="Find for Hero"
                style="font-size:30px"
            ></vue-typer>
            <v-row class="fill-height" align="center" justify="center">
                <div v-for="(hero, id) in heroes" :key="id">
                    <v-col :key="id">
                        <router-link
                            :to="{
                                name: 'ReadFirst',
                                params: { hero_id: hero.id }
                            }"
                        >
                            <v-img :src="hero.img_url" width="300px"></v-img>
                        </router-link>
                    </v-col>
                </div>
            </v-row>
        </div>

        <!-- タイトルから探す -->
        <div class="title-find">
            <p style="font-size:30px">タイトルから探す</p>
            <input type="text" placeholder="タイトル" v-model="title" />
            <v-btn small @click="findTitle(title)">検索</v-btn>
            <!-- 検索結果を表示 -->
            <ul>
                <li v-for="novel in findNovels">
                    <router-link
                        :to="{
                            name: 'ReadPaper',
                            params: {
                                hero_id: novel.hero_id,
                                paper_novel_id: novel.id
                            }
                        }"
                    >
                        <p>{{ novel.title }}</p>
                    </router-link>
                </li>
            </ul>
        </div>
    </v-container>
</template>
<script>
export default {
    components: {},

    data: () => ({
        hero_imgs: [
            { id: 1, url: "img/charactors/akira.png" },
            { id: 2, url: "img/charactors/lisa.png" },
            { id: 3, url: "img/charactors/ami&karin.png" },
            { id: 4, url: "img/charactors/mari.png" },
            { id: 6, url: "img/charactors/rui.png" }
        ],
        heroes: [],
        title: "",
        findNovels: {}
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
        },
        //タイトル検索
        findTitle: function($paper_novel_title) {
            axios
                .get("api/find/paper_novel/" + $paper_novel_title)
                .then(res => {
                    console.log(res.data);
                    this.findNovels = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped></style>
