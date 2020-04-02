<template>
    <div>
        <!-- 入力エリア -->
        <v-form>
            <div class="input-area">
                <p
                    v-if="title_toggle"
                    class="paper"
                    contenteditable="true"
                    id="novel_title"
                    placeholder="タイトルを入力してください"
                >
                    {{ novelData.title }}
                </p>
                <p
                    v-else
                    class="paper"
                    contenteditable="true"
                    id="novel_title"
                    placeholder="タイトルを入力してください"
                ></p>
            </div>
            <br />
            <!-- 保存ボタン -->
            <router-link
                :to="{
                    name: 'PaperEdit',
                    param: { novel_id: titlePost.novel_id }
                }"
            >
                <v-btn id="save" dark @click="saveTitle">保存する</v-btn>
            </router-link>
        </v-form>
        <!-- 入力エリアここまで -->
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート

// Vueの処理
export default {
    components: {},
    data() {
        return {
            //タイトルを判定
            title_toggle: false,
            //showNovel()のデータを格納
            novelData: "",
            //タイトルとテキストを格納
            titlePost: {}
        };
    },

    created() {
        this.titlePost.novel_id = this.$route.params.novel_id;
        // this.showHero();
        this.showNovel();
    },
    methods: {
        //主人公を表示する
        // showHero: function() {
        //     axios
        //         .get("api/get/hero/" + this.$route.params.hero_id)
        //         .then(res => {
        //             console.log(res);
        //             this.hero = res.data[0];
        //         })
        //         .catch(err => {
        //             console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        //         });
        // },

        //小説の情報を取得する
        showNovel: function() {
            axios
                .get("api/get/novel/" + this.$route.params.novel_id)
                .then(res => {
                    console.log(res);
                    this.novelData = res.data;
                    if (this.novelData.title) this.title_toggle = true;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },

        //保存：タイトルをNovelsテーブルに保存,statusを0
        saveTitle: function() {
            //PostするオブジェクトにDOMの内容をぶちこむ
            //タイトル
            this.titlePost.title = document.getElementById(
                "novel_title"
            ).textContent;

            //小説id
            this.titlePost.novel_id = this.$route.params.novel_id;

            //ステータスを0
            this.titlePost.status = 0;

            axios
                .post(
                    "api/update/novel/title/" + this.$route.params.novel_id,
                    this.titlePost
                )
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });

            axios
                .post("api/update/novel/close/" + this.$route.params.novel_id)
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
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
    margin: auto;
    margin-top: 10%;
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
    margin: auto;
    text-align: center;
    padding-top: 50px;
    height: 600px;
    border: 1px solid #000000;
}
</style>
