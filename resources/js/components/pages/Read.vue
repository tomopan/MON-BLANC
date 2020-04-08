<template>
    <v-container>
        <h1>『{{ novelData.title }}』</h1>

        <v-col v-for="(episode, i) in episodes" :key="i">
            <div class="paper">
                <div id="episode_text">
                    <p class="episode_text">
                        {{ episode.text }}
                    </p>
                </div>
            </div>
        </v-col>
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>


export default {
    components: {

    },
    data() {
        return {
            novelData: [],
            episodes: []
        };
    },

    created() {
        this.showNovel();
        this.showEpisode();
    },
    methods: {
        showNovel: function() {
            //Novelテーブルから情報を取得
            axios
                .get("api/get/novel/" + this.$route.params.novel_id)
                .then(res => {
                    this.novelData = res.data;
                    console.log(res);

                    // console.log(res.data[0].title);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        showEpisode: function() {
            //Episodesテーブルから情報を取得
            axios
                .get("api/get/episode/" + this.$route.params.novel_id)
                .then(res => {
                    this.episodes = res.data;
                    console.log(this.episodes);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        }
    }
};
</script>

<style scoped>
.paper {
    margin: auto;
    padding-top: 50px;
    height: 600px;
    right: 0;
    border: 1px solid #000000;
}

.episode_text {
    margin: 0 10px 0 auto;
    -webkit-writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: vertical-rl;
    font-size: 20px;
    line-height: 2em;
    overflow-x: scroll;
    outline: none;
}
</style>
