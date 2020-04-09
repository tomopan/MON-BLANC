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
                        v-for="(closeNovel, i) in closePaperNovels"
                        :key="i"
                        width="200px"
                        height="200px"
                        class="novel_card ma-4"
                    >
                        <router-link
                            :to="{
                                name: 'Read',
                                params: {
                                    hero_id: closeNovel.hero_id,
                                    novel_id: closeNovel.novel_id
                                }
                            }"
                        >
                            <v-img
                                :src="closeNovel.img_url"
                                height="170px"
                            ></v-img>
                            <p class="paper_text">{{ closeNovel.title }}</p>
                        </router-link>

                        <v-btn
                            class="ma-2"
                            tile
                            outlined
                            @click="openNovel(i, closeNovel.user_paper_order)"
                            >公開する</v-btn
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
            //非公開のペーパーノベルのデータを格納
            closePaperNovels:[],
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
                .then(res => {
                })
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
.novel_card {
    text-align: center;
}
.paper_text {
    color: black;
}
</style>
