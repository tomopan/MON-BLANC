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
                height="700"
                hide-delimiter-background
                show-arrows-on-hover
                hide-delimiters
            >
                <v-carousel-item v-for="(novel, i) in Novels" :key="i">
                    <v-sheet height="100%" color="white">
                        <v-row
                            height="100%"
                            class="fill-height"
                            align="center"
                            justify="center"
                        >
                            <div class="display-3" height="100%">
                                <router-link
                                    :to="{
                                        name: 'ReadPaper',
                                        params: {
                                            hero_id: $route.params.hero_id,
                                            paper_novel_id: novel.id
                                        }
                                    }"
                                >
                                    <div class="paper_text">
                                        {{ novel.first_sentence }}
                                    </div>
                                </router-link>
                            </div>
                        </v-row>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>
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
            dialog: true
        };
    },
    created() {
        //主人公データを取得
        this.fetchHeroData(this.$route.params.hero_id);
        this.showNovels();
    },
    computed: {
        ...mapGetters(["HeroData"]),
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
  color: #333;
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
*:focus {
outline: none;
}

.paper_text {
    writing-mode: vertical-rl;
    margin: auto;
    color: #333;
    font-size: 20px;

}

p{
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;

}

a{
    text-decoration: none;
}
</style>
