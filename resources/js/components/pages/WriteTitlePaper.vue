<template>
    <div class="cont">
        <!-- テキスト未入力の時のモーダル -->
        <v-dialog id="overlay" v-model="dialog" width="50%">
            <div id="content">
                <div class="write">
                    <p>テキストを入力してください</p>
                    <button
                        style="border:solid 2px #000;"
                        @click="dialog = false"
                    >
                        &nbsp;閉じる&nbsp;
                    </button>
                </div>
            </div>
        </v-dialog>
        <!-- テキスト100字以上の時のモーダル -->
        <v-dialog id="overlay" v-model="stopDialog" width="50%">
            <div id="content">
                <div class="write">
                    <p>100文字以内で入力してください</p>
                    <button
                        style="border:solid 2px #000;"
                        @click="stopDialog = false"
                    >
                        &nbsp;閉じる&nbsp;
                    </button>
                </div>
            </div>
        </v-dialog>
        <!-- モーダルここまで -->
        <p class="paper" id="m-title">小説のタイトル</p>

        <!-- ボタンたち -->
        <div class="buttons">
            <div id="buttons_icons">
                <!-- 戻るボタン -->
                <v-img
                    :src="'/img/write-page/close.png'"
                    class="close"
                    alt="close"
                    @click="$router.go(-1)"
                />
                <!-- あとでボタン -->
                <router-link
                    :to="{
                        name: 'EditStoryPaper',
                        param: {
                            hero_id: this.$route.params.hero_id,
                            user_paper_order: this.$route.params
                                .user_paper_order,
                            story_number: this.$route.params.story_number
                        }
                    }"
                >
                    <v-img
                        :src="'/img/write-page/atode.png'"
                        class="close"
                        alt="preview"
                    />
                </router-link>
                <!-- 保存ボタン -->
                <v-img
                    :src="'/img/write-page/save.png'"
                    class="close save"
                    alt="save"
                    @click="saveTitle"
                />
                <!-- ヒント -->
                <Hint :propsDialog="true" />
            </div>
            <!-- 主人公のアイコン -->
            <figure class="relative novel_title">
                <img
                    class="hero-icon"
                    :src="'img/charactors/' + HeroData.img_url"
                />
            </figure>
            <figcaption class="absolute fukidashi">
                <p class="novelText">{{ HeroData.hero_name }}</p>
                <p class="novelText">Age {{ HeroData.hero_birth }}</p>
            </figcaption>
        </div>
        <!-- ボタンここまで -->

        <!-- 入力エリア -->
        <div class="wrap-input-area">
            <div class="input-area">
                <div id="paper_text">
                    <p
                        v-if="title_toggle"
                        class="paper min"
                        contenteditable="true"
                        id="novel_title"
                        placeholder="小説のタイトルを入力してください"
                    >{{ novelData.title }}</p>
                    <p
                        v-else
                        class="paper min"
                        contenteditable="true"
                        id="novel_title"
                        placeholder="小説のタイトルを入力してください"
                    ></p>
                </div>
            </div>
            <p class="paper" id="title">小説のタイトル</p>
            <!-- 入力エリアここまで -->

            <!-- モバイルのボタンたち -->
            <div class="m_buttons">
                <div id="buttons_icons">
                    <!-- 保存ボタン -->
                    <v-btn color="#c9eff5" @click="saveTitle">保存</v-btn>
                    <!-- 戻るボタン -->
                    <v-btn class="close" alt="close" @click="$router.go(-1)"
                        >戻る</v-btn
                    >
                </div>
                <!-- ヒント -->
                <Hint :propsDialog="false" />
                <!-- 主人公のアイコン -->
                <figure class="relative novel_title">
                    <img
                        class="hero-icon"
                        :src="'img/charactors/' + HeroData.img_url"
                    />
                </figure>
                <figcaption class="absolute fukidashi">
                    <p class="novelText">{{ HeroData.hero_name }}</p>
                    <p class="novelText">Age {{ HeroData.hero_birth }}</p>
                </figcaption>
            </div>
        </div>
        <div></div>
    </div>
    <!-- モバイル表示 -->
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";
import Hint from "../items/Hint.vue";

// Vueの処理
export default {
    components: {
        Hint
    },
    data() {
        return {
            //タイトルを判定
            title_toggle: false,
            //showNovel()のデータを格納
            novelData: "",
            //タイトルとテキストを格納
            titlePost: {},
            // モーダル
            dialog: false,
            stopDialog: false
        };
    },
    computed: {
        ...mapGetters(["HeroData"])
    },
    created() {
        this.showNovel();
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
        //ペーパーノベルの情報を取得
        showNovel: function() {
            axios
                .get(
                    "api/fetch/paper_novel/" +
                        this.$route.params.user_paper_order
                )
                .then(res => {
                    console.log(res.data);
                    this.novelData = res.data;
                    if (this.novelData.title) this.title_toggle = true;
                    //主人公データを取得
                    this.fetchHeroData(this.novelData.hero_id);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },

        //タイトルペーパーをPaperNovelsテーブルに保存
        saveTitle: function() {
            //PostするオブジェクトにDOMの内容をぶちこむ
            //タイトル
            this.titlePost.title = document.getElementById(
                "novel_title"
            ).textContent;

            // Post
            axios
                .post(
                    "api/update/paper_title/" +
                        this.$route.params.user_paper_order,
                    this.titlePost
                )
                .then(res => {
                    this.$router.push({
                        name: "EditNovel",
                        param: {
                            user_paper_order: this.$route.params
                                .user_paper_order
                        }
                    });
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        }
    }
};
</script>

<style scoped>
/* 全体 */
*:focus {
    outline: none;
}
.cont {
    height: 100%;
    display: flex;
    justify-content: space-around;
    padding-top: 2em;
    background-color: #ffe8ae;
}

/* 小見出し */
.write {
    font-family: "Futura", "游ゴシック体", "YuGothic";
    font-weight: bold;
    background-color: #ffce97;
    text-align: center;
    margin: 1em;
}

/* モーダル */
#modal_text {
    /* writing-mode: vertical-rl; */
    margin: auto;
    padding-top: 10%;
}
#content {
    z-index: 2;
    width: 100%;
    padding: 1em;
    background-color: #fff;
    border: 1px dashed #000;
}

/* 入力 */
[contenteditable="true"]:empty:before {
    content: attr(placeholder);
    pointer-events: none;
    display: block; /* For Firefox */
    color: #a9a9a9;
}

/* 入力エリア */
.wrap-input-area {
    display: flex;
    margin-bottom: 3em;
}
.paper {
    display: block;
    -webkit-writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: vertical-rl;
    word-wrap: break-word;
    white-space: pre-wrap;
    font-size: 18px;
    line-height: 2em;
    outline: none;
    overflow-x: scroll;
}
.paper span {
    display: block;
}
.min {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
    cursor: url("/img/write-page/cursor.png"), auto;
}
.input-area {
    margin: auto;
    padding-top: 1em;
    height: 600px;
    width: 100px;
    margin-top: 2em;
    border: 1px solid #a9a9a9;
    background-color: white;
    overflow-x: scroll;
}
#story_text_input {
    display: block;
    margin: auto;
    height: 582px;
}
#story_text_input > div {
    height: 582px;
    font-size: 18px;
}

/* ボタン */
.buttons {
    display: flex;
    justify-content: center;
    flex-direction: column-reverse;
    height: 200px;
    margin-left: 5em;
    margin-top: 15em;
}
.close {
    opacity: 1;
    margin-top: 0.5em;
}

#buttons_icons {
    display: flex;
    flex-direction: column-reverse;
    height: 300px;
    margin-left: 5em;
    margin-top: 15em;
}
/* 主人公アイコン */
.hero-icon {
    width: 100px;
    top: 0;
    margin-left: 1em;
}
/* 主人公アイコンホバー */
.novelTitle {
    margin-bottom: 0 !important;
    font-weight: bold;
}
.relative {
    position: relative;
}

.absolute {
    position: absolute;
    bottom: 0.6em;
    left: 3em;
}

.fukidashi {
    display: none;
    width: 100px;
    height: 100px;
    position: absolute;
    top: 200px;
    left: 18em;
    padding: 16px;
    border-radius: 15px;
    border: solid 3px #555;
    background: #fff;
    color: #000;
    font-weight: bold;
    z-index: 4;
}

.fukidashi:before {
    content: "";
    position: absolute;
    top: -24px;
    left: 70%;
    margin-left: -17px;
    border: 12px solid transparent;
    border-bottom: 12px solid #fff;
    z-index: 6;
}

.fukidashi:after {
    content: "";
    position: absolute;
    top: -30px;
    left: 70%;
    margin-left: -19px;
    border: 14px solid transparent;
    border-bottom: 14px solid #555;
    z-index: 5;
}

.novel_title:hover + .fukidashi {
    display: block;
}

.m_buttons {
    display: none;
}
#m-title {
    display: none;
}
/* ------------------- */
/*      レスポンシブ     */
/*---------------------*/
@media screen and (max-width: 480px) {
    .cont {
        height: 100%;
        padding-top: 2em;
        display: block;
        background-color: #ffe8ae;
        text-align: center;
    }
    #title {
        display: none;
    }
    #m-title {
        display: block;
        margin-top: 4em;
    }
    /* 小見出し */
    .write {
        font-family: "Futura", "游ゴシック体", "YuGothic";
        font-weight: bold;
        background-color: #ffce97;
        text-align: center;
        margin: 1em;
    }
    .buttons {
        display: none;
    }
    .m_buttons {
        display: block;
        /* justify-content: center; */
        flex-direction: row;
        height: 0px;
        margin-left: 0em;
        margin-top: 0em;
    }
    .close {
        opacity: 1;
        margin-top: 0em;
    }

    #buttons_icons {
        display: flex;
        justify-content: space-around;
        flex-direction: row;
        height: 100px;
        margin-left: 0em;
        margin-top: 2em;
    }
    /* モーダル */
    #modal_text {
        /* writing-mode: vertical-rl; */
        margin: auto;
        padding-top: 10%;
    }
    #content {
        z-index: 2;
        width: 100%;
        padding: 1em;
        background-color: #fff;
        border: 1px dashed #000;
    }

    /* 入力 */
    [contenteditable="true"]:empty:before {
        content: attr(placeholder);
        pointer-events: none;
        display: block; /* For Firefox */
        color: #a9a9a9;
    }

    /* 入力エリア */
    .wrap-input-area {
        display: block;
        margin-bottom: 0em;
        height: 50px;
    }
    .paper {
        text-align: center;
        display: block;
        -webkit-writing-mode: horizontal-tb;
        -ms-writing-mode: tb-rl;
        writing-mode: horizontal-tb;
        word-wrap: break-word;
        white-space: pre-wrap;
        font-size: 18px;
        line-height: 2em;
        outline: none;
        overflow-y: scroll;
    }
    .paper span {
        display: block;
    }
    .min {
        font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN",
            "Yu Mincho Light", "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
        cursor: url("/img/write-page/cursor.png"), auto;
    }
    .input-area {
        margin: auto;
        padding-top: 0em;
        height: 30px;
        width: 80%;
        margin-top: 0em;
        border: 1px solid #a9a9a9;
        background-color: white;
        overflow-x: scroll;
    }
    #story_text_input {
        height: 5;
        display: block;
        margin: auto;
    }
    #story_text_input > div {
        height: 5;

        font-size: 18px;
    }
    /* 主人公アイコン */
    .hero-icon {
        width: 100px;
        margin-top: 20px;
        margin-left: 0em;
    }
    /* 主人公アイコンホバー */
    .novelTitle {
        margin-bottom: 0 !important;
        font-weight: bold;
    }
    .relative {
        position: relative;
    }

    .absolute {
        position: absolute;
        bottom: 0.6em;
        left: 3em;
    }

    .fukidashi {
        display: none;
        width: 100px;
        height: 100px;
        position: absolute;
        top: 500px;
        left: 10em;
        padding: 16px;
        border-radius: 15px;
        border: solid 3px #555;
        background: #fff;
        color: #000;
        font-weight: bold;
        z-index: 4;
    }

    .fukidashi:before {
        content: "";
        position: absolute;
        top: -24px;
        left: 70%;
        margin-left: -17px;
        border: 12px solid transparent;
        border-bottom: 12px solid #fff;
        z-index: 6;
    }

    .fukidashi:after {
        content: "";
        position: absolute;
        top: -30px;
        left: 70%;
        margin-left: -19px;
        border: 14px solid transparent;
        border-bottom: 14px solid #555;
        z-index: 5;
    }

    .novel_title:hover + .fukidashi {
        display: block;
    }
}
</style>
<style>
#app > div > main {
    margin: 0px;
    height: 100%;
}
</style>
