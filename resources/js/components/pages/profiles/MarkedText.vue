<template>
    <div>
        <div
            v-for="(markedText, i) in markedTexts"
            :key="i"
        >
            <router-link
                :to="{
                        name: 'ReadPaper',
                        params: {
                            hero_id:markedText.hero_id,
                            paper_novel_id: markedText.paper_novel_id
                        }
                        }"
                    >
                <p>{{markedText.text}}</p>
            </router-link>
        </div>
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
            //DBから取ってきたデータの格納
            markedTexts:[],
        }
    },
    watch: {
    '$route' (to, from) {
      // ルートの変更の検知
      if (to.path !== from.path) {
        this.showMarkedTexts();
      }
    },
    },
    created() {
        this.showMarkedTexts();
    },
    methods: {
        //ペーパーノベルを取得
        showMarkedTexts: function() {
            axios
                .get("api/get/mark_texts")
                .then(res => {
                    this.markedTexts = res.data;
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
*:focus {
outline: none;
}

.novel_card {
    text-align: center;
}

.v-btn{
    color: #333;
}

p{
    color: #333;
}
</style>
