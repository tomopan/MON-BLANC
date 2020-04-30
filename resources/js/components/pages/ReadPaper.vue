<template>
    <v-container>
        <!-- <p>マークされた数：{{ MarkCount }}</p>
        <p>選択中ストーリー番号：{{ markedStoryId }}</p>
        <p>選択中テキスト：{{ markedText }}</p> -->
        <v-row align="center" justify="center">
            <!-- ボタンエリア -->
            <div v-if="$store.state.login" class="btns">
                <v-icon color="#000" @click="dialog = true" large
                    >mdi-script-text-outline</v-icon
                >
                <v-icon
                    v-if="!bookmarkToggle"
                    color="#000"
                    @click="saveBookmark"
                    large
                    >mdi-bookmark-outline</v-icon
                >
                <v-icon
                    v-else-if="bookmarkToggle"
                    color="#000"
                    @click="deleteBookmark"
                    large
                    >mdi-bookmark</v-icon
                >
                <!-- タイトル未入力の時のモーダル -->
                <v-row justify="center">
                    <v-dialog v-model="dialog" persistent max-width="300">
                        <v-card v-if="markedText">
                            <v-card-title class="headline"
                                >文章をマーク</v-card-title
                            >
                            <v-card-text>{{ markedText }}</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="saveMarkText"
                                    >保存</v-btn
                                >
                            <!-- <div v-else-if="!markedText">
                                <v-card-title class="headline"
                                >文章を選択して</v-card-title
                            >
                            </div> -->
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="dialog = false"
                                    >閉じる</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                        <v-card v-if="!markedText">
                            <v-card-title class="headline"
                                >文章を選択してください</v-card-title
                            >
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="dialog = false"
                                    >閉じる</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
                <!-- モーダルここまで -->
            </div>
            <!-- 本エリア -->
            <div id="book" class="paper" @mouseup="getMarkText()">
                <div class="story_text">
                    <span class="title_text">{{ this.Title }}</span>
                    <router-link
                        :to="{
                            name: 'Profile',
                            params: {
                                user_name: WriterData.user_name
                            }
                        }"
                        >{{ WriterData.name }}</router-link
                    >
                </div>
            </div>
        </v-row>
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
    components: {},
    data() {
        return {
            //小説のデータ
            StoryPapersData: [],
            //タイトル
            Title: "",
            //作者のデータ
            WriterData: {},
            MarkCount: "",
            //選択したテキストを格納
            markedText: "",
            markedStoryId: "",
            postMarkedText: {},
            // ブックマークしてるか
            bookmarkToggle: "",
            dialog: false
        };
    },

    created() {
        this.showTitle();
        this.showStoryPapers();
        this.checkBookmark();
        this.showMarkCount();
    },
    mounted() {
        this.$nextTick(function() {
            const test = document.getElementById("book");
        });
    },
    methods: {
        showStoryPapers: function() {
            //StoryPapersテーブルから情報を取得
            axios
                .get(
                    "api/get/story_papers/" + this.$route.params.paper_novel_id
                )
                .then(res => {
                    this.StoryPapersData = res.data;
                    //改行コードを<br>に変換
                    this.StoryPapersData.forEach(el => {
                        el.text = el.text.replace(/\\n|\r\n|\r|\n/g, "<br>");
                        // DOMを追加（ここからじゃないとTurn.js使えない）
                        $("#book").append(
                            "<div class='story_text' style='writing-mode: vertical-rl; background-color:#fff'><br/><br/><span style='padding:50px'>" +
                                el.text +
                                "</span></div>"
                        );
                    });
                    this.turnPage();
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        showTitle: function() {
            //PaperNovelsテーブルからタイトルを取得
            axios
                .get(
                    "api/fetch/paper_novel_titile/" +
                        this.$route.params.paper_novel_id
                )
                .then(res => {
                    //非公開の場合はtopへリダイレクト
                    if (res.data.status == 0) {
                        this.$router.push({
                            name: "Top"
                        });
                    } else {
                        this.Title = res.data.title;
                        this.WriterData.name = res.data.name;
                        this.WriterData.user_name = res.data.user_name;
                    }
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        //マーカー機能
        getMarkText: function() {
            //要素のIDを取得
            const story_area = document.getElementsByClassName("story_area");
            //テキストを代入
            const selectedText = window.getSelection().toString();
            this.markedText = selectedText;
            //ストーリー番号を代入
            this.markedStoryId = 1;
        },
        saveMarkText: function() {
            //POSTするデータを格納
            //小説id
            this.postMarkedText.paper_novel_id = this.$route.params.paper_novel_id;
            //ストーリーid
            this.postMarkedText.story_paper_id = this.markedStoryId;
            //テキスト
            this.postMarkedText.text = this.markedText;
            axios
                .post("api/post/mark_text", this.postMarkedText)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        showMarkCount: function() {
            //マークされている数を取得して格納
            axios
                .get("api/get/mark_count/" + this.$route.params.paper_novel_id)
                .then(res => {
                    this.MarkCount = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        // ブックマークする
        saveBookmark: function() {
            axios
                .post("api/post/bookmark/" + this.$route.params.paper_novel_id)
                .then(res => {
                    this.checkBookmark();
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        // ブックマークを外す
        deleteBookmark: function() {
            axios
                .post("api/destroy/bookmark/" + this.bookmarkToggle)
                .then(res => {
                    this.checkBookmark();
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        // ブックマークしてるか確かめる
        checkBookmark: function() {
            axios
                .get("api/check/bookmark/" + this.$route.params.paper_novel_id)
                .then(res => {
                    console.log(res.data);
                    if (!res.data) this.bookmarkToggle = false;
                    else this.bookmarkToggle = res.data[0].id;
                    console.log(this.bookmarkToggle);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        // turn.jsの処理
        turnPage: function() {
            // DOMを追加（ここからじゃないとTurn.js使えない）
            $("#book").turn({
                direction: "rtl",
                width: 1076,
                height: 700
            });
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

.container {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
    background-color: #fffcfc;
}

.paper {
    margin: auto;
    /* padding-top: 50px; */
    height: 640px;
    /* right: 10px; */
    /* border: 1px solid #000000; */
}

.story_text {
    /* margin: 0 10px 0 auto; */
    -webkit-writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: vertical-rl;
    font-size: 20px;
    line-height: 2em;
    overflow-x: scroll;
    outline: none;
    white-space: pre-wrap;
    background-color: white;
    text-align: center;
    justify-content: center;
}
.title_text {
    margin: 10% 20%;
}
</style>
