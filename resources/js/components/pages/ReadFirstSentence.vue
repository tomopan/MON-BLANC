<template>
    <div>
        <h1>最初の一文ページ</h1>
        <v-container
            class="d-flex flex-row mb-6"
            color="grey lighten-2"
            flat
            tile
        >
            <!-- <div> -->
            <!-- 主人公の画像 -->
            <!-- <v-img :src="hero.img_url" height="400px" width="400px">
                    <v-card-title class="title white--text">
                        <v-row
                            class="fill-height flex-column"
                            justify="space-between"
                        >
                            <p
                                class="mt-4 subheading text-left"
                                style="color:white"
                            >
                                主人公ID : {{ hero.id }}
                            </p>
                            <p
                                class="mt-4 subheading text-left"
                                style="color:white"
                            >
                                名前 : {{ hero.hero_description }}
                            </p>
                        </v-row>
                    </v-card-title>
                </v-img>
            </div> -->
            <!-- 書かれている小説を表示 -->

            <!-- カルーセルで表示 -->
            <v-carousel
                cycle
                height="400"
                hide-delimiter-background
                show-arrows-on-hover
                hide-delimiters
            >
                <v-carousel-item v-for="(novel, i) in novels" :key="i">
                    <v-sheet height="100%" color="white">
                        <v-row
                            class="fill-height"
                            align="center"
                            justify="center"
                        >
                            <div class="display-3">
                                <router-link
                                    :to="{
                                        name: 'Read',
                                        params: {
                                            hero_id: $route.params.hero_id,
                                            novel_id: novel.id
                                        }
                                    }"
                                >
                                    <p class="paper_text">
                                        {{ novel.first_sentence }}
                                    </p>
                                </router-link>
                            </div>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>

            <!-- ペーパー表示 -->
            <!-- <v-container class="grey lighten-5">
                <v-row>
                    <v-col v-for="(novel, i) in novels" :key="i">
                        <v-card style="height:100%;width:1000px" tile outlined>
                            <p class="paper_text">{{ novel.first_sentence }}</p>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container> -->

            <!-- <div class="pa-md-4 mx-lg-auto">
                <ul>
                    <li v-for="(novel, i) in novels" :key="i">
                        <router-link
                            :to="{
                                name: 'Read',
                                params: {
                                    hero_id: $route.params.hero_id,
                                    novel_id: novel.id
                                }
                            }"
                            >{{ novel.first_sentence }}</router-link
                        >
                        by {{ novel.name }}
                    </li>
                </ul>
            </div> -->
        </v-container>
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
    components: {},

    data() {
        return {
            hero: {},
            novels: []
        };
    },
    watch: {
        // ルートが変更されたらこのメソッドを再び呼び出します
        $route: "showHero"
    },
    created() {
        //hero_idに遷移した主人公idを代入
        this.showHero();
        this.showNovels();
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        showHero: function() {
            axios
                .get("api/get/hero/" + this.$route.params.hero_id)
                .then(res => {
                    console.log(res.data);
                    this.hero = res.data[0];
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        //主人公に書かれている小説のタイトルを表示
        showNovels: function() {
            axios
                .get("api/get/novels/" + this.$route.params.hero_id)
                .then(res => {
                    console.log(res.data);
                    this.novels = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
.paper_text {
    writing-mode: vertical-rl;
    margin: auto;
    color: black;
    font-size: 20px;
}
</style>
