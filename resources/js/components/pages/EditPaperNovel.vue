<template>
    <div>
        <br />

        <grid-layout
            :layout.sync="layout"
            :col-num="12"
            :row-height="30"
            :is-draggable="true"
            :is-resizable="false"
            :is-mirrored="true"
            :vertical-compact="false"
            :margin="[10, 10]"
            :use-css-transforms="true"
            :preventCollision="true"
        >
            <grid-item
                v-for="(paper, i) in papers"
                :x="paper.x"
                :y="paper.y"
                :w="paper.w"
                :h="paper.h"
                :i="i"
                :key="i"
                :class="{ title_paper: i == 0, text_paper: i != 0 }"
            >
                <router-link
                    v-if="i == 0"
                    :to="{
                        name: 'WriteTitlePaper',
                        params: { user_paper_order: $route.params.user_paper_order },
                    }"
                >
                    <p v-if="title_toggle" class="title_text">
                        {{ paper.text }}
                    </p>
                    <p v-else class="title_text">タイトルを編集</p>
                </router-link>

                <p 
                    v-if="i == 1" class="paper_text" 
                >
                    【最初の一文】
                    <br>
                    {{ paper.text }}
                </p>
                <router-link
                    v-if="i >= 2"
                    :to="{
                        name: 'EditStoryPaper',
                        params: {
                            user_paper_order:$route.params.user_paper_order,
                            story_number:paper.story_number
                        },
                    }"
                >
                <p  class="paper_text">{{ paper.text }}</p>
                </router-link>
            </grid-item>
        </grid-layout>

        <!-- ペーパー追加ボタン -->
        <router-link
            :to="{
                name: 'WriteStoryPaper',
                params: {
                    user_paper_order: this.$route.params.user_paper_order,
                    story_number:story_number
                },
            }"
        >
            <v-btn class="mx-2">
                <v-icon dark>mdi-plus</v-icon>
            </v-btn>
        </router-link>
        <!-- 公開ボタン -->
        <router-link
            :to="{
                name: 'Profile',
            }"
        >
            <v-btn
                class="ma-2"
                tile
                outlined
                @click="openNovel()"
                >公開する</v-btn
            >
        </router-link>
        <!-- 一時保存 -->
        <router-link
            :to="{
                name: 'Profile',
            }"
        >
            <v-btn
                class="ma-2"
                tile
                outlined
                @click="closeNovel()"
                >一時保存</v-btn
            >
        </router-link>
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script src="vue-grid-layout.umd.min.js"></script>
<script>
// インポート
import VueGridLayout from "vue-grid-layout";

// Vueの処理
export default {
    components: {
        GridLayout: VueGridLayout.GridLayout,
        GridItem: VueGridLayout.GridItem,
    },
    data() {
        return {
            //GridLayout用
            layout: [],
            justify: [
                "start",
                "center",
                "end",
                "space-around",
                "space-between",
            ],
            //showNovel()のデータ格納
            PaperNovelData: "",
            //showPapers()のデータ格納
            papers: [],
            //titleの判定
            title_toggle: false,
            story_number:""
        };
    },

    created() {
        this.showNovel();
        this.showPapers();
    },
    methods: {
        //ペーパーノベルの情報を取得
        showNovel: function () {
            axios
                .get("api/fetch/paper_novel/" + this.$route.params.user_paper_order)
                .then((res) => {
                    this.PaperNovelData = res.data;
                    if (this.PaperNovelData.title) this.title_toggle = true;
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        //ストーリーペーパーを取得
        showPapers: function () {
            axios
                .get("api/get/story_papers_edit/" + this.$route.params.user_paper_order)
                .then((res) => {
                    this.papers = res.data;
                    this.papers.unshift({
                        text: this.PaperNovelData.title,
                    });
                    this.papers.forEach(function (e, i) {
                        if (i % 2 != 0) {
                            e.x = i - 1;
                            e.y = 6;
                            e.w = 2;
                            e.h = 5;
                        } else {
                            e.x = i;
                            e.y = 0;
                            e.w = 2;
                            e.h = 5;
                        }
                    });
                    this.story_number = this.papers.length + 1
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        openNovel: function () {
            axios
                .post("api/update/paper_novel_open/" + this.$route.params.user_paper_order)
                .then((res) => {
                    console.log(this.writedNovels);
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        closeNovel: function () {
            axios
                .post("update/paper_novel_close/" + this.$route.params.user_paper_order)
                .then((res) => {
                    console.log(this.writingNovels);
                })
                .catch((err) => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
    },
};
</script>

<style scoped>
*:focus {
outline: none;
}

.paper_text {
    writing-mode: vertical-rl;
    margin: auto;
    position: absolute;
    right: 0;
}
/* .title_card {
} */
.title_text {
    writing-mode: vertical-rl;
    margin: 0 auto;
    margin-top: 5%;
}

.text_paper {
    border: 1px solid;
}

.title_paper {
    border: 3px solid;
}

a,p{
    color: #333;
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;

}

a:hover{
    text-decoration: none;
}

</style>
