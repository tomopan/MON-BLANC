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
                <!-- <p
                    class="paper"
                    contenteditable="true"
                    id="novel_title"
                    placeholder="タイトルを入力してください"
                ></p> -->
                <!-- 小説入力 -->
                <div id="episode_text">
                    <p
                        class="paper"
                        contenteditable="true"
                        id="episode_text_input"
                    >
                        {{ novelData.first_sentence }}
                    </p>
                </div>
            </div>

            <br />
            <!-- 一時保存ボタン -->
            <router-link
                :to="{
                    name: 'PaperEdit',
                    param: { novel_id: episodePost.novel_id }
                }"
            >
                <v-btn id="save" dark @click="saveEpisode"
                    >保存する</v-btn
                >
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
            novelData: "",
            //タイトルとテキストを格納
            episodePost: {},
            //モーダルのステータス
            dialog: true
        };
    },

    created() {
        this.episodePost.novel_id = this.$route.params.novel_id;
        this.showHero();
        this.showNovel();
    },
    methods: {
        //主人公を表示する
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

        //小説の情報を取得する
        showNovel: function() {
            axios
                .get("api/get/novel/" + this.$route.params.novel_id)
                .then(res => {
                    console.log(res);
                    this.novelData = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },

        //一時保存：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを0
        saveEpisode: function() {
            //PostするオブジェクトにDOMの内容をぶちこむ
            //タイトル
            // this.episodePost.title = document.getElementById(
            //     "novel_title"
            // ).textContent;
            //テキスト
            this.episodePost.text = document.getElementById(
                "episode_text_input"
            ).textContent;

            //小説id
            this.episodePost.novel_id = this.$route.params.novel_id;

            //ステータスを0
            this.episodePost.status = 0;

            axios
                .post("api/post/episode", this.episodePost)
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
        },

        //公開：エピソードタイトルとテキストをEpisodesテーブルに保存,statusを1
        openEpisode: function() {
            //ステータスを1
            this.episodePost.status = 1;

            axios
                .post("api/post/episode", this.episodePost)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
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
    margin-top: 10%;
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
    margin: auto;
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
#episode_text {
    grid-row: 1 / 12;
    grid-column: 1 / 10;
    /* border: 1px solid #000000; */

    /* display: grid; */
    /* grid-template-columns: 150px 1fr; */
}
#episode_text_input {
    margin: 0 50px 0 auto;
    /* border: 1px solid #000000; */
}
</style>
