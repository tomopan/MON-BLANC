<template>
  <div>
    <p>最初の一文を書く</p>

    <!-- 主人公の名前を表示 -->
    <p>{{hero.hero_description}}</p>

    <!-- タイトル入力 -->
    <v-form>
      <p
        class="paper"
        contenteditable="true"
        placeholder="最初の一文を書いてください"
        id="first_sentence"
      >{{text}}</p>
      <br />
      <!-- <router-link :to="{name:'Write',params:{hero_id:$route.params.hero_id,novel_id:postNovelId}}"> -->
      <v-btn style="display:none" color="" id="save" dark @click="saveFirstSentence">完了</v-btn>

      <!-- </router-link> -->
    </v-form>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->


<script>
// Vueの処理
export default {
  components: {},
  data() {
    return {
      //タイトルとテキストを格納
      firstSentencePost: {},
      postNovelId: null,
      hero: {},
      text: ""
    };
  },

  created() {
    this.showHero();
  },
  mounted() {
    console.log(document.getElementById("first_sentence").textContent);
    this.openBtn();
  },
  methods: {
    ToConsole: function() {
      console.log(this.text);
    },
    //小説のタイトルを保存
    saveFirstSentence: function() {
      //PostするオブジェクトにDOMの内容をぶちこむ
      this.firstSentencePost.first_sentence = document.getElementById(
        "first_sentence"
      ).textContent;
      axios
        .post(
          "api/post/firstsentence/" + this.$route.params.hero_id,
          this.firstSentencePost
        )
        .then(res => {
          console.log(res.data);
          // console.log(res.data.id);
          this.$router.push({
            name: "Write",
            params: {
              hero_id: this.$route.params.hero_id,
              novel_id: res.data.id
            }
          });
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    //API叩いてマッチした主人公データを取得
    showHero: function() {
      axios
        .get("api/get/hero/" + this.$route.params.hero_id)
        .then(res => {
          console.log(res.data);
          this.hero = res.data[0];
        })
        .catch(err => {
          console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
        });
    },
    openBtn() {
      //句読点が押されたらボタンを出現させる処理
      const target = document.getElementById("first_sentence");

      const observer = new MutationObserver(records => {
        // 変化が発生したときの処理を記述
        let p = document.getElementById("first_sentence");
        const text = p.textContent;
        let btn = document.getElementById("save");
        if (text.slice(-1) == "。") save.style.display = "";
        else save.style.display = "none";
        // console.log(text.slice(-1));
      });
      observer.observe(target, {
        // オプションを指定
        characterData: true,
        attributes: true,
        childList: true,
        subtree: true
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

.paper {
  display: block;
  /* width: 10%; */
  margin: auto;
  margin-top: 10%;
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
</style>

