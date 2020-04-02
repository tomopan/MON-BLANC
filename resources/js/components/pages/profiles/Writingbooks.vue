<template>
    <div>
        <h1>非公開の小説</h1>
        <!-- {{writedNovels}} -->
        <v-card
            v-for="(writedNovel, i) in writedNovels"
            :key="i"
            width="200px"
            height="200px"
            class="novel_card"
        >
            <router-link
                :to="{
                    name: 'Read',
                    params: {
                        hero_id: writedNovel.hero_id,
                        novel_id: writedNovel.novel_id
                    }
                }"
            >
                <v-img :src="writedNovel.img_url" height="170px"></v-img>
                <p class="paper_text">{{ writedNovel.title }}</p>
            </router-link>

            <v-btn
                class="ma-2"
                tile
                outlined
                @click="openNovel(i, writedNovel.novel_id)"
                >公開する</v-btn
            >
        </v-card>
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
            writedEpisodes: [],
            writedNovels: []
        };
    },

    created() {
        // this.showWritedEpisode();
        this.showWritedNovel();
    },
    methods: {
        showWritedNovel: function() {
            axios
                .get("api/get/novel/writing")
                .then(res => {
                    console.log(res);
                    this.writedNovels = res.data.map(data => {
                        const obj = {};
                        obj["title"] = data.title;
                        obj["hero_id"] = data.hero_id;
                        obj["novel_id"] = data.id;
                        obj["img_url"] = data.img_url;
                        return obj;
                    });
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
        },
        openNovel: function(i, novel_id) {
            axios
                .post("api/update/novel/open/" + novel_id)
                .then(res => {
                    console.log(this.writedNovels);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            // 配列からも削除してデータバインディング
            this.writedNovels.splice(i, 1);
        }
    }
};
</script>

<style scoped>
.novel_card {
    text-align: center;
}
</style>
