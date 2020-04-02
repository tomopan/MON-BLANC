<template>
    <div>
        <v-container
            class="d-flex flex-row mb-6"
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
                                :src="hero.img_url"
                                id="modal_img"
                                width="300px"
                                height="400px"
                            >
                            </v-img>
                              <p id="modal_text">
                                  好きな著者の第一文を選びましょう。
                                  <br>
                                  <br>
                                  スワイプで、それぞれ別の著者が書いた第一文を見ることができます。
                              </p>
                            <v-btn icon id="modal_btn" @click="dialog = false">
                                <v-icon x-large dark>mdi-transfer-down</v-icon>
                            </v-btn>
                        </div>
                    </v-card>
                </v-dialog>
            </div>
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
            novels: [],
            dialog: true
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
/* モーダル */
#modal {
    margin: auto;
    padding-top: 10%;
    position: relative;
    text-align: center;
}
#modal_text{
  position: absolute;/*絶対配置*/
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%,-50%);
  -webkit-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
  margin:0;
  padding:0;
  font-size: 20px;

  }
  #modal_img{
    margin: auto;
    opacity: 0.5;
  }
#modal_btn{
  margin-top: 5%;
  margin:auto;
}

/* テキスト */
.paper_text {
    writing-mode: vertical-rl;
    margin: auto;
    color: black;
    font-size: 20px;
}
</style>
