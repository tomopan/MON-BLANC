<template>
  <div>
    <v-img class="icon" src="img/write-page/tutorial.png" @click="dialog = !dialog"></v-img>
    <div id="overlay" v-show="dialog">
      <div id="content">
                <div class="write">

        <v-btn icon color="#000" @click="dialog=false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
          <p class="title">物語を生み出すためのヒント</p>
          <p>あなたはなぜこの主人公を選んだの？</p>
          <textarea name id cols="30" rows="2"></textarea>
          <p>この主人公の最後はハッピーエンド？バッドエンド？</p>
          <textarea name id cols="30" rows="2"></textarea>
          <p>その主人公は今、どういう心情？もしくは状況？</p>
          <textarea name id cols="30" rows="2"></textarea>
          <p>主人公は今どこにいる？どんな風景が見えている？</p>
          <textarea name id cols="30" rows="2"></textarea>
          <p>この小説がもし手紙だとしたら、誰に向けて書く？</p>
          <textarea name id cols="30" rows="2"></textarea>
          <p><button>保存</button></p>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data: () => ({
    dialog: false
  }),

  created() {},

  methods: {}
};
</script>

<style scoped>
*:focus {
    outline: none;
}

.icon {
  width: 100px;
}
#overlay {
  /*　要素を重ねた時の順番　*/
  z-index: 1;

  /*　画面全体を覆う設定　*/
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);

  /*　画面の中央に要素を表示させる設定　*/
  display: flex;
  align-items: center;
  justify-content: center;
}

#content {
  z-index: 2;
  width: 50%;
  padding: 1em;
  background-color: #fff;
  border: 1px dashed #000;
}


.write{
  font-family: "Futura","游ゴシック体", "YuGothic";
  font-weight: bold;
  background-color:#FFCE97;
  text-align: center;
  margin: 1em;
}
textarea{
  border: 3px solid;
  background-color: #fff;

}
p{
  margin-block-end: 0.5em;
}
button{
  margin: 0.5em;
}
.title{
  font-family: "Futura","游ゴシック体", "YuGothic";
  font-weight: bold;
  font-size: 1em;
  margin-bottom: 0.8em;
}
</style>