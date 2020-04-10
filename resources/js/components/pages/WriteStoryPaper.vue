<template>
    <div>
        <!-- モーダル -->
        <div class="text-center">
            <v-dialog v-model="dialog" fullscreen>
                <v-card>
                    <div id="modal_text">
                        <div id="modal_text_inline">
                            <br />
                            <p>第一文が完成しました。</p>
                            <br />
                            <p>次はあなたが選んだ主人公や、</p>
                            <br />
                            <p>今あなたが思い描く風景、</p>
                            <br />
                            <p>目の前の形式などを、描写してみましょう。</p>
                            <br />
                            <p>そうして、あなたの言葉を連ねていきましょう。</p>
                            <br />
                            <p>
                                まずは十六行。 これは手紙一枚分ほどの長さです。
                            </p>
                            <br />
                            <p>思いやアイディアをフィクションとして、</p>
                            <br />
                            <p>想像力を使って形にしてみましょう。</p>
                        </div>
                        <v-btn icon id="modal_btn" @click="dialog = false">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                    </div>
                </v-card>
            </v-dialog>
        </div>
        <!-- モーダルここまで -->

        <!-- 入力エリア -->
        <v-form>
            <div class="input-area">
                <!-- 小説入力 -->
                <div id="paper_text">
                    <p  v-if="isFristStoryPaper"
                        class="paper"
                        contenteditable="true"
                        id="story_text_input"
                    >
                        {{ PaperNovelData.first_sentence }}
                    </p>
                    <p  v-else
                        class="paper"
                        contenteditable="true"
                        id="story_text_input"
                        placeholder="新しいペーパー"
                    ></p>
                </div>
            </div>
            <!-- 一時保存ボタン -->
            <router-link
                :to="{
                    name: 'EditPaperNovel',
                    params: {
                        user_paper_order:$route.params.user_paper_order
                    }
                }"
            >
                <v-btn id="save" dark @click="savePaper">保存する</v-btn>
            </router-link>
        </v-form>
        <!-- 入力エリアここまで -->
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";

// Vueの処理
export default {
    components: {},
    data() {
        return {
            //ペーパーノベルの情報を格納
            PaperNovelData: "",
            //タイトルとテキストを格納
            PaperNovelPost: {},
            //最初か追加かを判定
            isFristStoryPaper:false,
            //モーダルの開閉
            dialog:false
        };
    },

    created() {
        //主人公データを取得
        this.fetchHeroData(this.$route.params.hero_id);

        //Postデータにuser_paper_orderを入れる
        this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;

        //ペーパーノベルのデータを取得
        this.showNovel();
    },

    computed: {
        ...mapGetters(["HeroData"]),
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),

        //ストーリーペーパーの情報を取得する

        //ペーパーノベルの情報を取得する
        showNovel: function () {
            axios
                .get("api/fetch/paper_novel/" + this.$route.params.user_paper_order)
                .then((res) => {
                    console.log(res);
                    this.PaperNovelData = res.data;
                    //最初のストーリーペーパーだったら、モーダルとファーストセンテンスを挿入する処理
                    if(this.PaperNovelData.story_number == 0){
                        this.isFristStoryPaper = true;
                        this.dialog = true
                    }
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },

        //一時保存：テキストをstory_papersテーブルに保存,statusを0
        savePaper: function () {
            //PostするオブジェクトにDOMの内容をぶちこむ
            //テキスト
            this.PaperNovelPost.text = document.getElementById(
                "story_text_input"
            ).textContent;

            //小説id
            this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;

            //ステータスを0(非公開)
            this.PaperNovelPost.status = 0;

            // ストーリーペーパーの内容をPost
            axios
                .post("api/post/story_paper", this.PaperNovelPost)
                .then((res) => {})
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
    },
};
</script>

<style scoped>
/* モーダル */
#modal_text {
    writing-mode: vertical-rl;
    margin: auto;
    padding-top: 10%;
}

/* 入力 */

[contenteditable="true"]:empty:before {
    content: attr(placeholder);
    pointer-events: none;
    display: block; /* For Firefox */
    color: #a9a9a9;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.paper {
    display: block;
    /* width: 10%; */
    margin: auto;
    margin-top: 10px;
    /* padding: 40px; */
    -webkit-writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: vertical-rl;
    font-size: 20px;
    line-height: 2em;
    overflow-x: scroll;
    outline: none;
}

.paper span {
    display: block;
}
#save {
    display: block;
    margin: auto;
}
.input-area {
    margin: 3%;
    padding-top: 50px;
    height: 600px;
    display: grid;
    grid-template-columns: 150px 1fr;
    border: 1px solid #000000;
}
#novel_title {
    margin: 0;
    padding-top: 50px;
    grid-row: 1 / 12;
    grid-column: 10 / 12;
    /* border: 1px solid #000000; */
}
#paper_text {
    grid-row: 1 / 12;
    grid-column: 1 / 10;
    /* border: 1px solid #000000; */

    /* display: grid; */
    /* grid-template-columns: 150px 1fr; */
}
#story_text_input {
    margin: 0 50px 0 auto;
    /* border: 1px solid #000000; */
}
</style>
