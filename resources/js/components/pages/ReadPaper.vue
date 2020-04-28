<template>
    <v-container>
        <p>作者:</p>
        <router-link
            :to="{
                name: 'Profile',
                params: {
                    user_name: WriterData.user_name
                }
            }"
            >{{ WriterData.name }}</router-link
        >
        <p>マークされた数：{{ MarkCount }}</p>
        <p>選択中ストーリー番号：{{ markedStoryId }}</p>
        <p>選択中テキスト：{{ markedText }}</p>
        <v-btn id="save" @click="saveMarkText">マークする</v-btn>
        <v-btn @click="saveBookmark">ブックマークする</v-btn>


<!-- マークアップありの実装を取っておく -->
        <!-- <v-col v-for="(story, i) in StoryPapersData" :key="i">
            <div class="paper" @mouseup="getMarkText(story.id)">
                <div class="story_text" v-html="story.text"></div>
            </div>
        </v-col> -->

        <div id="magazine" class="paper"></div>
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
            // テスト
            items: [1, 2, 3, 4]
        };
    },

    created() {
        this.showTitle();
        this.showStoryPapers();
        this.showMarkCount();
    },
    mounted() {
        this.$nextTick(function() {
            const test = document.getElementById("magazine");
            // const test2 = document.getElementById("magazine2");
            console.log(test);
            // console.log(test2);
            // $("#magazine2").turn();
            // $("#magazine").turn();
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
                    //ファーストセンテンスページは消す
                    this.StoryPapersData.shift();
                    //改行コードを<br>に変換
                    this.StoryPapersData.forEach(el => {
                        el.text = el.text.replace(/\\n|\r\n|\r|\n/g, "<br>");
                        // DOMを追加（ここからじゃないとTurn.js使えない）
                        $("#magazine").append(
                            "<div class='story_text' style='writing-mode: vertical-rl; background-color:#fffcfc'><br/><br/><span style='margin:50px'>" +
                                el.text +
                                "</span></div>"
                        );
                    });
                    $("#magazine").turn({ direction: "rtl" });
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
                    // DOMを追加（ここからじゃないとTurn.js使えない）
                    $("#magazine").append(
                        "<div class='story_text' style='writing-mode: vertical-rl; background-color:#fffcfc'><br/><br/><span style='margin:10%'>『" +
                            this.Title +
                            "』</span></div>"
                    );
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        //マーカー機能
        getMarkText: function(story_paper_id) {
            //要素のIDを取得
            const story_area = document.getElementsByClassName("story_area");
            //テキストを代入
            const selectedText = window.getSelection().toString();
            this.markedText = selectedText;
            //ストーリー番号を代入
            this.markedStoryId = story_paper_id;
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
        // ブックマーク
        saveBookmark: function() {
            axios
                .post("api/post/bookmark/" + this.$route.params.paper_novel_id)
                .then(res => {
                    console.log(res.data);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
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
}
</style>
