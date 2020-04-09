<template>
    <div>
        <v-row>
            <v-col cols="12">
                <v-row
                    :align="alignment"
                    :justify="justify"
                    style="height: 300px;"
                >
                    <v-card
                        v-for="(openNovel, i) in OpenPaperNovels"
                        :key="i"
                        width="200px"
                        height="200px"
                        class="novel_card ma-4"
                    >
                        <router-link
                            :to="{
                                name: 'Read',
                                params: {
                                    hero_id: openNovel.hero_id,
                                    novel_id: openNovel.novel_id
                                }
                            }"
                        >
                            <v-img
                                :src="openNovel.img_url"
                                height="170px"
                            ></v-img>
                            <p class="paper_text">{{ openNovel.title }}</p>
                        </router-link>
                        <v-btn
                            class="ma-2"
                            tile
                            outlined
                            @click="closeNovel(i, openNovel.user_paper_order)"
                            >非公開にする</v-btn
                        >
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
            //公開中のペーパーノベルのデータを格納
            OpenPaperNovels:[],
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
    '$route' (to, from) {
      // ルートの変更の検知
      if (to.path !== from.path) {
        this.showNovelsOpened();
      }
    },
    },
    created() {
        this.showNovelsOpened();
    },
    methods: {
        //ペーパーノベルを取得
        showNovelsOpened: function() {
            axios
                .get("api/get/open_paper_novels")
                .then(res => {
                    console.log(res);
                    this.OpenPaperNovels = res.data.map(data => {
                        const obj = {};
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
        //非公開ボタン
        closeNovel: function(i, user_paper_order) {
            console.log(user_paper_order)
            axios
                .post("api/update/paper_novel_close/" + user_paper_order)
                .then(res => {
                    console.log(res)
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            // 配列からも削除してデータバインディング
            this.OpenPaperNovels.splice(i, 1);
        }
    }
};
</script>

<style scoped>
.novel_card {
    text-align: center;
}
.paper_text {
    color: black;
}
</style>
