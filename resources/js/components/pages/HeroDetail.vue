<template>
    <v-container>
    <!-- 主人公コンポーネント（仮）/後でコンポーネントを挿入-->
        <v-img src="https://assets.st-note.com/production/uploads/images/17220311/rectangle_large_type_2_e0050b10549e41bb8deb5a3d00e732d4.jpeg?fit=bounds&format=jpeg&quality=45&width=960"
        aspect-ratio="1.4"></v-img>

    <!-- 主人公説明ドキュメント（ダミー） -->
      <v-card
    class="mx-auto"
    max-width="344"
  >
    <v-card-text>
      <div>Name</div>
      <p class="display-1 text--primary">
        ルネ・デカルト
      </p>
      <p> Info</p>
      <div class="text--primary">
        1596年3月31日 - 1650年2月11日）は、<br>
        フランス生まれの哲学者、数学者。合理主義哲学の祖であり、<br>
        近世哲学の祖として知られる。
      </div>
    </v-card-text>
    <v-card-actions>
      <v-btn
        text
        color="deep-purple accent-4"
      >
        Learn More
      </v-btn>
    </v-card-actions>
  </v-card>

      <!-- 執筆ボタン -->
    <WriteBtnComponent/>

    </v-container>

</template>

<!-- 以下にscript/cssを記述 -->
<script>
import WriteBtnComponent from "../items/WriteBtnComponent.vue";

export default {
  components: {
    WriteBtnComponent,
    SheetFooter: {
        functional: true,

        render (h, { children }) {
          return h('v-sheet', {
            staticClass: 'mt-auto align-center justify-center d-flex',
            props: {
              color: 'rgba(0, 0, 0, .36)',
              dark: true,
              height: 100,
            },
          }, children)
        },
      },
  },
  data() {
    return {
    }
  },
  

  created() {

  },
  methods: {

  }
};
</script>

<style scoped>

</style>