<template>
    <div>
        <!-- <router-link to="dialog = !dialog"> -->
        <v-img
            :src="'/img/write-page/hint.png'"
            class="close"
            alt="hint"
            @click="dialog = !dialog"
        />
        <v-btn class="m_close" color="#f8d04b" @click="dialog = !dialog">
            ヒント
        </v-btn>
        <!-- </router-link> -->
        <div id="overlay" v-show="dialog">
            <div id="content">
                <div class="write">
                    <v-btn icon color="#000" @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <p class="title">物語を生み出すためのヒント</p>
                    <p>あなたはなぜこの主人公を選んだの？</p>
                    <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        v-model="answers.q_1"
                    ></textarea>
                    <p>この主人公の最後はハッピーエンド？<br class="sp_br">バッドエンド？</p>
                    <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        v-model="answers.q_2"
                    ></textarea>
                    <p>その主人公は今、どういう心情？<br class="sp_br"もしくは状況？</p>
                    <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        v-model="answers.q_3"
                    ></textarea>
                    <p>主人公は今どこにいる？<br class="sp_br">どんな風景が見えている？</p>
                    <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        v-model="answers.q_4"
                    ></textarea>
                    <p>この小説がもし手紙だとしたら、<br class="sp_br">誰に向けて書く？</p>
                    <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        v-model="answers.q_5"
                    ></textarea>
                    <p></p>
                    <button style="border:solid 2px #000" @click="saveAnswers">
                        &nbsp;保存&nbsp;
                    </button>
                    <p id="save_text">保存しました！</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        propsDialog: Boolean
    },
    data() {
        return {
            dialog: this.propsDialog,
            answers: {
                q_1: "",
                q_2: "",
                q_3: "",
                q_4: "",
                q_5: ""
            },
        };
    },

    created() {
        this.showAnswers();
    },

    methods: {
        saveAnswers: function() {
            this.answers.user_paper_order = this.$route.params.user_paper_order;
            //post
            axios
                .post("api/post/hints/", this.answers)
                .then(res => {
                    $("#save_text").fadeIn(1500);
                    $("#save_text").fadeOut(1500);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        showAnswers: function() {
            //show
            axios
                .get("api/get/hints/" + this.$route.params.user_paper_order)
                .then(res => {
                    this.answers = res.data;
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

.icon {
    width: 60px;
}
#overlay {
    /*　要素を重ねた時の順番　*/
    z-index: 1;

    /*　画面全体を覆う設定　*/
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);

    /*　画面の中央に要素を表示させる設定　*/
    display: flex;
    align-items: center;
    justify-content: center;
}

#content {
    z-index: 2;
    width: 50%;
    padding: 1em;
    background-color: #fff;
    border: 1px solid #000;
}

.write {
    font-family: "Futura", "游ゴシック体", "YuGothic";
    font-weight: bold;
    background-color: #ffce97;
    text-align: center;
    margin: 1em;
}
textarea {
    border: 3px solid;
    background-color: #fff;
}
p {
    margin-block-end: 0.5em;
}
button {
    margin: 0.5em;
}
.title {
    font-family: "Futura", "游ゴシック体", "YuGothic";
    font-weight: bold;
    font-size: 1em;
    margin-bottom: 0.8em;
}
.icon {
    cursor: pointer;
}
#save_text {
    display: none;
}
.m_close {
    display: none;
}
.sp_br{
    display:none;
}

/* レスポンシブ */
@media screen and (max-width: 768px) {
    #content {
        width: 80%;
    }
}

/* レスポンシブ */
@media screen and (max-width: 480px) {
    #content {
        z-index: 2;
        width: 90%;
        padding: 1em;
        background-color: #fff;
        border: 1px solid #000;
        font-size: 14px;
    }
    textarea {
        width: 80%;
    }
    .close {
        display: none;
    }
    .m_close {
    display: inline;
    }
        .sp_br{
        display:block;
    }

  }
</style>
