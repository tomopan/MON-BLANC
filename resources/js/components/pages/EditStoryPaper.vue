<template>
    <div>
<p>ペーパー編集</p>
        <!-- 入力エリア -->
        <v-form>
            <div class="input-area">
                <!-- 小説入力 -->
                <div id="paper_text">
                    <p
                        class="paper"
                        contenteditable="true"
                        id="story_text_input"
                    >
                        {{ PaperNovelData.text }}
                    </p>
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
                <v-btn id="save" dark @click="editPaper">更新する</v-btn>
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

        //ストーリーペーパーの情報を取得
        showNovel: function () {
            axios
                .get("api/fetch/story_paper/" + this.$route.params.user_paper_order+ "/" + this.$route.params.story_number)
                .then((res) => {
                    this.PaperNovelData = res.data;
                    console.log(res.data)
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        //textを更新する
        editPaper: function () {
            //PostするオブジェクトにDOMの内容をぶちこむ
            //テキスト
            this.PaperNovelPost.text = document.getElementById(
                "story_text_input"
            ).innerHTML.replace(/(<(p|div))/ig, '\\n$1').replace(/(<([^>]+)>)/ig, "");

            //user_paper_order
            this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;

            // story_numberを格納
            this.PaperNovelPost.story_number = this.$route.params.story_number;

            //最初の一文が更新されていたら、paper_novelsテーブルも更新
            if(this.$route.params.story_number == 2){
                const firstSentence = this.PaperNovelPost.text.split('。')[0] + "。";
                this.PaperNovelPost.first_sentence = firstSentence;
                console.log(this.PaperNovelPost)
                // 更新
                axios
                    .post("api/update/first_sentence", this.PaperNovelPost)
                    .then((res) => {
                        console.log(res.data)
                    })
                    .catch((err) => {
                        console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                    });
            }

            // ストーリーペーパーの内容を更新
            axios
                .post("api/edit/story_paper", this.PaperNovelPost)
                .then((res) => {
                    console.log(res.data)
                })
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

*:focus {
outline: none;
}

a{
    color: #333;
}

a:hover{
    text-decoration: none;
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
