<template>
    <v-container class="pa-4 text-center">
        <!-- 主人公から探す -->
        <div class="hero-find">
            <vue-typer
                :repeat="0"
                :type-delay="100"
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
                            <v-img
                                :src="'img/books/' + hero.img_url"
                                width="200px"
                            ></v-img>
                        </router-link>
                    </v-col>
                </div>
            </v-row>
        </div>

        <!-- タイトルから探す -->
        <!-- <div class="title-find">
            <p style="font-size:30px">タイトルから探す</p>
            <input type="text" placeholder="タイトル" v-model="title" />
            <v-btn small @click="findTitle(title)">検索</v-btn> -->
        <!-- 検索結果を表示 -->
        <!-- <ul>
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
        </div> -->
    </v-container>
</template>
<script>
export default {
    components: {},

    data: () => ({
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
