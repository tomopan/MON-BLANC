<template>
  <div>
    <v-img class="icon" src="img/write-page/tutorial.png" @click="dialog = !dialog"></v-img>
    <div id="overlay" v-show="dialog">
      <div id="content">
        <v-btn icon color="#000" @click="dialog=false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <p>はじめて小説を書くあなたにヒントをあげます</p>
        <p>○主人公を選んだ理由は？</p>
        <textarea name id cols="30" rows="5"></textarea>
        <p>○どんなシーンを想像した？</p>
        <textarea name id cols="30" rows="5"></textarea>
        <button>保存</button>
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
  background: #fff;
}
</style>

<style>
</style>