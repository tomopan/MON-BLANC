<template>
    <v-container
        class="d-flex flex-row mb-6 pt-8"
        color="grey lighten-2"
        flat
        tile
    >
        <!-- モーダルを表示 -->
        <div class="text-center">
            <v-dialog v-model="dialog" fullscreen>
                <v-card>
                    <div id="modal">
                        <v-img
                            :src="HeroData.img_url"
                            id="modal_img"
                            width="300px"
                            height="400px"
                        >
                        </v-img>
                        <p id="modal_text">
                            好きな著者の第一文を選びましょう。
                            <br />
                            <br />
                            スワイプで、それぞれ別の著者が書いた第一文を見ることができます。
                        </p>
                        <v-btn icon id="modal_btn" @click="dialog = false">
                            <v-icon x-large dark>mdi-transfer-down</v-icon>
                        </v-btn>
                    </div>
                </v-card>
            </v-dialog>
        </div>
        <v-row>
            <v-img :src="HeroData.img_url" width="100px" height="400px">
            </v-img>

            <v-row class="fill-height" align="center" justify="center">
                <v-card
                    v-for="(novel, i) in Novels"
                    :key="i"
                    class="mx-auto"
                    width="300px"
                    height="400px"
                >
                    <router-link
                        :to="{
                            name: 'ReadPaper',
                            params: {
                                hero_id: $route.params.hero_id,
                                paper_novel_id: novel.id
                            }
                        }"
                    >
                        <div class="text_area">
                            <div class="title_area">
                                <p class="title_text">{{ novel.title }}</p>
                            </div>
                            <div class="first_area">
                                <p class="paper_text">
                                    {{ novel.first_sentence }}
                                </p>
                            </div>
                        </div>
                    </router-link>
                </v-card>
            </v-row>
        </v-row>
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
//インポート
import { mapActions, mapGetters } from "vuex";

export default {
    components: {},

    data() {
        return {
            //取得したペーパーノベルのデータを格納
            Novels: [],
            //モーダルの開閉
            dialog: false
        };
    },
    created() {
        //主人公データを取得
        this.fetchHeroData(this.$route.params.hero_id);
        this.showNovels();
    },
    computed: {
        ...mapGetters(["HeroData"])
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
        //主人公に書かれている小説のタイトルを表示
        showNovels: function() {
            axios
                .get("api/get/paper_novels/" + this.$route.params.hero_id)
                .then(res => {
                    this.Novels = res.data;
                    console.log(this.Novels);
                    //第一文が100字以上だったら省略
                    this.Novels.forEach(function(e) {
                        if (e.first_sentence.length >= 100)
                            e.first_sentence =
                                e.first_sentence.substr(0, 100) + "・・・";
                    });
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        swipe(direction) {
            this.swipeDirection = direction;
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

/* モーダル */
#modal {
    margin: auto;
    padding-top: 10%;
    position: relative;
    text-align: center;
}
#modal_text {
    position: absolute; /*絶対配置*/
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    margin: 0;
    padding: 0;
    font-size: 20px;
    color: #333;
}
#modal_img {
    margin: auto;
    opacity: 0.5;
}
#modal_btn {
    margin-top: 5%;
    margin: auto;
}

/* テキスト */
*:focus {
    outline: none;
}
.text_area {
    padding: 50px;
    display: flex;
    justify-content: flex-end;
    flex-direction: row-reverse;
}
.paper_text {
    writing-mode: vertical-rl;
    margin: 50px;
    color: #333;
    font-size: 15px;
    height: 300px;
}
.title_area {
    text-align: right;
    margin: 0 0 0 auto;
}
.title_text {
    color: #333;
    writing-mode: vertical-rl;
    font-size: 20px;
}

p {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}

a {
    text-decoration: none;
}
</style>
