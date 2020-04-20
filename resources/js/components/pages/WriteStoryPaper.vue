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
                {{charaCount}}文字{{lineCount}}行
            <v-row>
            <!-- アイコンたち -->
            <v-img
                class="icon"
                src="img/write-page/continue.png"
            >
            </v-img>
            <v-img
                class="icon"
                src="img/write-page/font.png"
            >
            </v-img>
            <v-img
                class="icon"
                src="img/write-page/tutorial.png"
            >
            </v-img>
            <v-img
                class="icon"
                src="img/write-page/write.png"
            >
            </v-img>
            </v-row>
            <!-- アイコンたちここまで   -->
            <div class="input-area" >
                <!-- 小説入力 -->
                <div id="paper_text">
                    <div v-if="isFristStoryPaper"
                        class="paper"
                        contenteditable="true"
                        id="story_text_input"
                        @input="sync"
                    >
                    <div>{{ PaperNovelData.text }}</div>
                    </div>

                    <div v-else
                        class="paper"
                        contenteditable="true"
                        id="story_text_input"
                        placeholder="新しいペーパー"
                    ></div>
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
                    <v-img
                        class="icon"
                        src="img/write-page/book.png"
                        @click="savePaper"
                    >
                    </v-img>
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
            charaCount:"",
            lineCount:"",
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
    beforeMount(){

    },
    mounted(){
        this.changeLine();
        this.stopLine();
        this.innerContent = this.content;
    },
    computed: {
        ...mapGetters(["HeroData"]),
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
        //contenteditableのv-model化
        sync (e) {
            this.content = e.target.innerHTML
        },
        //ペーパーノベルの情報を取得する
        showNovel: function () {
            axios
                .get("api/fetch/story_paper/" + this.$route.params.user_paper_order+ "/" + this.$route.params.story_number)
                .then((res) => {
                    this.PaperNovelData = res.data;
                    //最初のストーリーペーパーだったら、モーダルとファーストセンテンスを挿入する処理
                    if(this.PaperNovelData.story_number == 1){
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
            //テキスト(改行コードを挿入)
            this.PaperNovelPost.text = document.getElementById(
                "story_text_input"
            ).innerHTML.replace(/(<(p|div))/ig, '\\n$1').replace(/(<([^>]+)>)/ig, ""); 

            //小説id
            this.PaperNovelPost.user_paper_order = this.$route.params.user_paper_order;

            //ステータスを0(非公開)
            this.PaperNovelPost.status = 0;

            // story_numberを格納
            this.PaperNovelPost.story_number = this.$route.params.story_number;

            // ストーリーペーパーの内容をPost
            axios
                .post("api/post/story_paper", this.PaperNovelPost)
                .then((res) => {})
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
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
                dummy.parentNode.removeChild(dummy)
                } else {
                clone.setStart(range.endContainer, fixedPosition);
                clone.setEnd(range.endContainer, fixedPosition + 1);
                const rect = clone.getBoundingClientRect();
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
*:focus {
outline: none;
}

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
    /* margin-top: 10px; */
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
    margin: 0 auto;
    padding-top: 50px;
    height: 700px;
    width: 700px;
    display: grid;
    grid-template-columns: 150px 1fr;
    border: 1px dotted #a9a9a9;
}
#paper_text {
    grid-row: 1 / 12;
    grid-column: 1 / 10;
}


#story_text_input > div{
    height: 640px;
    font-size: 20px;
}

#story_text_input {
    margin: 0 50px 0 auto;
    /* border: 1px solid #000000; */
}

.icon {
    width: 100px;
}
</style>
