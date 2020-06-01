<template>
  <div>
    <div class="select-area">
      <p>セレクトページ</p>
      <!-- 初めて小説を書く -->
      <router-link
        :to="{
                name: 'WriteFirstTime',
                params: { hero_id: $route.params.hero_id },
            }"
      >
        <p>はじめて小説を書く</p>
      </router-link>
      <!-- 小説を書く -->
      <router-link
        :to="{
                name: 'WriteFirstSentence',
                params: { hero_id: $route.params.hero_id },
            }"
      >
        <p>小説を書く</p>
      </router-link>
    </div>
  </div>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";

// Vueの処理
export default {
  components: {},
  data() {
    return {};
  },

  created() {
    //主人公データを取得
    this.fetchHeroData(this.$route.params.hero_id);
    if (!this.$store.state.login) this.$store.state.drawerLoginModal = true;
  },
  beforeMount() {},
  mounted() {},
  computed: {
    ...mapGetters(["HeroData"])
  },
  methods: {
    //API叩いてマッチした主人公データを取得
    ...mapActions(["fetchHeroData"])
  }
};
</script>

<style scoped>
</style>
