<template>
    <div>
        <!-- 主人公の名前を表示 -->
        <p class="heroName">{{ HeroData.hero_name }}</p>

        <!-- タイトル入力 -->
        <v-form>
            <div class="input-area" >
                <div id="paper_text">
                    <div
                        class="paper"
                        contenteditable="true"
                        placeholder="最初の一文を書いてください。"
                        id="first_sentence"
                    >{{ text }}</div>
                    <br />
                    <!-- <router-link :to="{name:'Write',params:{hero_id:$route.params.hero_id,novel_id:postNovelId}}"> -->
                    <v-btn
                        style="display: none;"
                        color=""
                        id="save"
                        dark
                        @click="saveFirstSentence"
                        >完了</v-btn
                    >
                </div>
            </div>
            <!-- </router-link> -->
        </v-form>
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
            //paper_novelsテーブルにPostするデータを格納
            firstSentencePost: {},
            //story_papersテーブルにPostするデータを格納
            storyPaperPost:{},
            text: "",
        };
    },
    created() {
        this.fetchHeroData(this.$route.params.hero_id);
    },
    mounted() {
        console.log(document.getElementById("first_sentence").textContent);
        this.openBtn();
    },
    computed: {
        ...mapGetters(["HeroData"]),
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),

        //小説のタイトルを保存
        saveFirstSentence: function () {
            //PostするオブジェクトにDOMの内容をぶちこむ
            this.firstSentencePost.first_sentence = document.getElementById(
                "first_sentence"
            ).textContent;

            //paper_novelsテーブルにPost
            axios
                .post(
                    "api/post/firstsentence/" + this.$route.params.hero_id,
                    this.firstSentencePost
                )
                .then((res) => {
                    console.log(res.data);
                    //Write.vueへページ遷移させる
                    this.$router.push({
                        name: "WriteStoryPaper",
                        params: {
                            user_paper_order: res.data.user_paper_order,
                            story_number:1
                        },
                    });
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });

        },

        //句読点が押されたらボタンを出現させる関数
        openBtn() {
            const target = document.getElementById("first_sentence");

            const observer = new MutationObserver((records) => {
                // 変化が発生したときの処理を記述
                let p = document.getElementById("first_sentence");
                const text = p.textContent;
                let btn = document.getElementById("save");
                if (text.slice(-1) == "。") save.style.display = "";
                else save.style.display = "none";
            });
            observer.observe(target, {
                // オプションを指定
                characterData: true,
                attributes: true,
                childList: true,
                subtree: true,
            });
        },

                //32文字以上入力したら改行処理
        changeLine:function(){
            //要素のIDを取得
            const target = document.getElementById("story_text_input");

            //DOMの変更を監視
            const observer = new MutationObserver((records) => {
                // 変化が発生したときの処理を記述
                let p = document.getElementById("story_text_input");
                //文字数をdataに格納
                let text = p.textContent;
                this.charaCount = text.length;

                //行数をdataに格納
                const tBox = document.getElementById("story_text_input");
                this.lineCount = tBox.childElementCount;
            });
            observer.observe(target, {
                // オプションを指定
                characterData: true,
                childList: true,
                subtree: true,
            });
            document.onselectionchange = () => {
                const range = window.getSelection().getRangeAt(0)
                const clone = range.cloneRange()
                const fixedPosition = range.endOffset
                // 末尾の文字列を選択した時はダミーテキストを追加して選択範囲を拡大する
                if (fixedPosition + 1 > range.endContainer.length) {
                const dummy = document.createTextNode('&#8203;')
                clone.insertNode(dummy)
                clone.selectNode(dummy)
                const rect = clone.getBoundingClientRect();
                console.log(rect);
                dummy.parentNode.removeChild(dummy)
                } else {
                clone.setStart(range.endContainer, fixedPosition);
                clone.setEnd(range.endContainer, fixedPosition + 1);
                const rect = clone.getBoundingClientRect();
                console.log(rect);
                }
                clone.detach()
                }
        },

        //17行で制限
        stopLine:function(){
            const tBox = document.getElementById("story_text_input");
            this.lineCount = tBox.childElementCount;
            //エンターキーを無効にする
            document.addEventListener('keydown', function(e){
                if (tBox.childElementCount == 17 && e.keyCode === 13) {
                    e.preventDefault();
                }else if(tBox.childElementCount == 17 && e.which === 13){
                    e.preventDefault();
                }
            });
        }

    },
};
</script>

<style scoped>
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

.heroName{
    font-family: 'Lao MN','serif';
}

form{
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;
}

.paper {
    display: block;
    /* width: 10%; */
    margin: auto;
    /* margin-top: 5%; */
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
    /* padding-top: 50px; */
    height: 700px;
    display: grid;
    grid-template-columns: 150px 1fr;
    /* border: 1px solid #000000; */
}

#paper_text {
    grid-row: 1 / 10;
    grid-column: 1 / 10;
    /* border: 1px solid #000000; */

    /* display: grid; */
    /* grid-template-columns: 150px 1fr; */
}

#first_sentence {
    margin: 0 auto 0;
    height: 640px;
    font-size: 20px;

    /* border: 1px solid #000000; */
}

</style>
