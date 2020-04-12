<template>
    <v-container>
        <h1>『{{Title}}』</h1>

        <v-col v-for="(story, i) in StoryPapersData" :key="i">
            <div class="paper">
                <div id="episode_text">
                    <p class="episode_text">
                        {{ story.text }}
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
            StoryPapersData: [],
            Title:"",
        };
    },

    created() {
        this.showTitle();
        this.showStoryPapers();
    },
    methods: {
        showStoryPapers: function() {
            //StoryPapersテーブルから情報を取得
            axios
                .get("api/get/story_papers/" + this.$route.params.paper_novel_id)
                .then(res => {
                    this.StoryPapersData = res.data;
                    console.log(res.data);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        },
        showTitle: function() {
            //PaperNovelsテーブルからタイトルを取得
            axios
                .get("api/fetch/paper_novel_titile/" + this.$route.params.paper_novel_id)
                .then(res => {
                    this.Title = res.data.title;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜
                });
        }
    }
};
</script>

<style scoped>
*:focus {
outline: none;
}

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
