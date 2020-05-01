<template>
    <div class="wrap">
            <v-content>

        <v-navigation-drawer
            class="nav accent-4"
            permanent
        >
        <v-list>
            <v-img :src="img_url" id="hero_img"></v-img>

            <v-list-item
                v-for="item in items"
                :key="item.title"
                link
            >

            <v-list-item-icon>
                <!-- 主人公の画像を表示 -->
                <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        </v-list>

    </v-navigation-drawer>
    </v-content>

        <!-- タイトル入力 -->
    <v-content>
        <v-container fluid>
    <v-form>
        <div class="input-area">
            <div id="paper_text">
                <div
                    class="paper"
                    contenteditable="true"
                    placeholder="第一文を書いて、句読点（。）を打ちましょう。"
                    id="first_sentence"
                >{{ text }}</div>
                <br />
                <v-btn
                    style="display: none;"
                    id="save"
                    dark
                    @click="saveFirstSentence"
                    >1ページ目を書く</v-btn
                >
            </div>
        </div>
    </v-form>
        </v-container>
    </v-content>
    <div class="icons">
        <img :src="'/img/write-page/write.png'"  class="icon" alt="write"/>
        <img :src="'/img/write-page/font.png'"  class="icon" alt="read" />
        <img :src="'/img/write-page/font-size.png'" class="icon" alt="read" />
        <Hint />
        <a href="/" alt="daiki">
            <img :src="'/img/write-page/continue.png'" class="icon" alt="read" />
        </a>
    </div>
    </div>
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
            //paper_novelsテーブルにPostするデータを格納
            firstSentencePost: {},
            //story_papersテーブルにPostするデータを格納
            storyPaperPost: {},
            text: "",
            charaCount: "",
            lineCount: "",
            img_url: "",
            // items: [
            //     { title: 'Dashboard' },
            //     { title: 'Account' },
            //     { title: 'Admin' },
            // ],
        };
    },
    created() {
        // this.fetchHeroData(this.$route.params.hero_id);
        this.showHero();
        //ログインしてなかったらモーダル表示
        // if (!this.$store.state.login) this.$store.state.drawerLoginModal = true;
        // this.img_url = "img/charactors/" + this.$store.state.HeroData.img_url;
    },
    mounted() {
        // console.log(document.getElementById("first_sentence").textContent);
        this.openBtn();
    },
    computed: {
        ...mapGetters(["HeroData"])
    },
    methods: {
        //API叩いてマッチした主人公データを取得
        ...mapActions(["fetchHeroData"]),
        //主人公データを取得
        showHero: function() {
            axios
                .get("api/get/hero_fetch/" + this.$route.params.hero_id)
                .then(res => {
                    this.img_url = "img/charactors/" + res.data.img_url;
                    console.log(res.data);
                });
        },
        //小説のタイトルを保存
        saveFirstSentence: function() {
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
                .then(res => {
                    //Write.vueへページ遷移させる
                    this.$router.push({
                        name: "EditStoryPaper",
                        params: {
                            user_paper_order: res.data.user_paper_order,
                            story_number: 1
                        }
                    });
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },

        //句読点が押されたらボタンを出現させる関数
        openBtn() {
            const target = document.getElementById("first_sentence");

            const observer = new MutationObserver(records => {
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
                subtree: true
            });
        },

        //32文字以上入力したら改行処理
        changeLine: function() {
            //要素のIDを取得
            const target = document.getElementById("first_sentence");

            //DOMの変更を監視
            const observer = new MutationObserver(records => {
                // 変化が発生したときの処理を記述
                let p = document.getElementById("first_sentence");
                //文字数をdataに格納
                let text = p.textContent;
                this.charaCount = text.length;

                //行数をdataに格納
                const tBox = document.getElementById("first_sentence");
                this.lineCount = tBox.childElementCount;
            });
            observer.observe(target, {
                // オプションを指定
                characterData: true,
                childList: true,
                subtree: true
            });
            document.onselectionchange = () => {
                const range = window.getSelection().getRangeAt(0);
                const clone = range.cloneRange();
                const fixedPosition = range.endOffset;
                // 末尾の文字列を選択した時はダミーテキストを追加して選択範囲を拡大する
                if (fixedPosition + 1 > range.endContainer.length) {
                    const dummy = document.createTextNode("&#8203;");
                    clone.insertNode(dummy);
                    clone.selectNode(dummy);
                    const rect = clone.getBoundingClientRect();
                    console.log(rect);
                    dummy.parentNode.removeChild(dummy);
                } else {
                    clone.setStart(range.endContainer, fixedPosition);
                    clone.setEnd(range.endContainer, fixedPosition + 1);
                    const rect = clone.getBoundingClientRect();
                    console.log(rect);
                }
                clone.detach();
            };
        },

        //17行で制限
        stopLine: function() {
            const tBox = document.getElementById("first_sentence");
            this.lineCount = tBox.childElementCount;
            //エンターキーを無効にする
            document.addEventListener("keydown", function(e) {
                if (tBox.childElementCount == 17 && e.keyCode === 13) {
                    e.preventDefault();
                } else if (tBox.childElementCount == 17 && e.which === 13) {
                    e.preventDefault();
                }
            });
        }
    }
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

.heroName {
    font-family: "Lao MN", "serif";
}

form {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
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
    margin-top: 1em;
    /* border: 1px solid #000000; */

    /* display: grid; */
    /* grid-template-columns: 150px 1fr; */
}

#first_sentence {
    margin: 0 auto 0;
    height: 582px;
    font-size: 18px;

    /* border: 1px solid #000000; */
}

#hero_img {
    margin: 10% auto;
    height: 200px;
    width: 150px;
    object-fit: cover;
    object-position: 100% 0%
}

.nav{
    background-color: #F7E9D1;
}

.wrap{
    display: flex;
}

v-navigation-drawer{
    height: 100vh;
}

.icons{
    display: flex;
    flex-direction: column;
    margin:1em 4em;

}

.icon{
    width: 60px;
    height: auto;
}
#app > div > header{
    display: none!important;
}


</style>
<style>
#app > div > main > div > div > main:nth-child(2) > div{
    margin-right: 0;
    flex: 0 0 auto!important;
    flex-grow: 0!important;
    flex-shrink: 0!important;
    flex-basis: auto!important;
}

</style>