<template>
<div>
    <h1>主人公ページ</h1>
    <p>Hero_id : {{hero_id}}</p>
    <WriteBtnComponent/>

    <HeroImgComponent/>
</div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
import WriteBtnComponent from "../items/WriteBtnComponent.vue";
import HeroImgComponent from "../items/HeroImgComponent.vue";



export default {
  components: {
    WriteBtnComponent,
    HeroImgComponent,
  },
  data() {
    return {
      hero_id:"",
    };
  },

  created() {

  },
  methods: {

  }
};
</script>

<style scoped>

</style>