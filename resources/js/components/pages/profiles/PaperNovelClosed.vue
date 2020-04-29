<template>
    <div class="font">
        <v-row>
            <v-col cols="12">
                <v-row
                    :align="alignment"
                    :justify="justify"
                    style="height: 300px;"
                >
                    <v-card
                        v-for="(closeNovel, i) in closePaperNovels"
                        :key="i"
                        width="200px"
                        height="200px"
                        class="novel_card ma-4"
                    >
                        <v-hover v-slot:default="{ hover }" open-delay="100">
                            <div>
                                <v-img :src="closeNovel.img_url" height="170px">
                                    <v-btn
                                        :class="{ 'show-btns': hover }"
                                        color="transparent"
                                        tile
                                        outlined
                                        @click="
                                            openNovel(
                                                i,
                                                closeNovel.user_paper_order
                                            )
                                        "
                                        >公開する</v-btn
                                    >
                                    <router-link
                                        :to="{
                                            name: 'EditPaperNovel',
                                            params: {
                                                user_paper_order:
                                                    closeNovel.user_paper_order
                                            }
                                        }"
                                    >
                                        <v-btn
                                            :class="{ 'show-btns': hover }"
                                            color="transparent"
                                            tile
                                            outlined
                                            >編集</v-btn
                                        >
                                    </router-link></v-img
                                >
                                <p class="paper_text">{{ closeNovel.title }}</p>
                            </div>
                        </v-hover>
                    </v-card>
                </v-row>
            </v-col>
        </v-row>
    </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
export default {
    components: {
        //執筆中の小説のエピソード名を格納
    },
    data() {
        return {
            //非公開のペーパーノベルのデータを格納
            closePaperNovels: [],
            // グリッド用
            alignmentsAvailable: [
                "start",
                "center",
                "end",
                "baseline",
                "stretch"
            ],
            alignment: "center",
            dense: false,
            justifyAvailable: [
                "start",
                "center",
                "end",
                "space-around",
                "space-between"
            ],
            justify: "center"
        };
    },
    watch: {
        $route(to, from) {
            // ルートの変更の検知
            if (to.path !== from.path) {
                this.showNovelsClosed();
            }
        }
    },
    created() {
        // this.showWritedEpisode();
        this.showNovelsClosed();
    },
    methods: {
        showNovelsClosed: function() {
            axios
                .get("api/get/close_paper_novels")
                .then(res => {
                    console.log(res);
                    this.closePaperNovels = res.data.map(data => {
                        const obj = {};
                        obj["id"] = data.id;
                        obj["title"] = data.title;
                        obj["hero_id"] = data.hero_id;
                        obj["novel_id"] = data.id;
                        obj["img_url"] = data.img_url;
                        obj["user_paper_order"] = data.user_paper_order;
                        return obj;
                    });
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        openNovel: function(i, user_paper_order) {
            axios
                .post("api/update/paper_novel_open/" + user_paper_order)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            // 配列からも削除してデータバインディング
            this.closePaperNovels.splice(i, 1);
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

.font {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}

.novel_card {
    text-align: center;
}

.v-btn {
    color: #333;
}
p {
    color: #333;
}
/* ホバー時に出すボタン */
.show-btns {
    color: rgba(0, 0, 1) !important;
}
</style>
