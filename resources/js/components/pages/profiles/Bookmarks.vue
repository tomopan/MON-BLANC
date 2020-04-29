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
                        v-for="(bookmarkNovel, i) in BookmarkNovels"
                        :key="i"
                        width="200px"
                        height="200px"
                        class="novel_card ma-4"
                    >
                        <router-link
                            :to="{
                                name: 'ReadPaper',
                                params: {
                                    hero_id: bookmarkNovel.hero_id,
                                    paper_novel_id: bookmarkNovel.paper_novel_id
                                }
                            }"
                        >
                            <v-img
                                :src="bookmarkNovel.img_url"
                                height="170px"
                            ></v-img>
                            <p class="paper_text">{{ bookmarkNovel.title }}</p>
                        </router-link>
                        <!-- 削除ボタン -->
                        <v-btn
                            class="ma-2"
                            tile
                            outlined
                            @click.native.stop="dialog = true"
                            >削除</v-btn
                        >
                        <!-- 削除のモーダル -->
                        <v-layout row justify-center>
                            <v-dialog v-model="dialog" max-width="290">
                                <v-card>
                                    <v-card-title class="headline"
                                        >削除しますか?</v-card-title
                                    >
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn @click.native="dialog = false"
                                            >戻る</v-btn
                                        >
                                        <v-btn
                                            @click="
                                                destroy(i, bookmarkNovel.id)
                                            "
                                            >削除する</v-btn
                                        >
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-layout>
                        <!-- モーダルここまで -->
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
            BookmarkNovels: [],
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
            justify: "center",
            dialog: false
        };
    },
    watch: {
        $route(to, from) {
            // ルートの変更の検知
            if (to.path !== from.path) {
                this.showBookmarks();
            }
        }
    },
    created() {
        // this.showWritedEpisode();
        this.showBookmarks();
    },
    methods: {
        showBookmarks: function() {
            axios
                .get("api/get/bookmarks")
                .then(res => {
                    console.log(res.data);
                    this.BookmarkNovels = res.data;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        destroy(i, $bookmark_id) {
            axios
                .post("api/destroy/bookmark/" + $bookmark_id)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            // 配列からも削除してデータバインディング
            this.BookmarkNovels.splice(i, 1);
            //モーダルを閉じる
            this.dialog = false;
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
</style>
