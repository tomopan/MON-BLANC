<template>
  <v-layout row justify-center>
    <!-- アイコン -->
    <v-icon @click="openLoginModal" color="#000">mdi-login</v-icon>

    <!-- ▼▼▼ログイン画面モーダル▼▼▼ -->
    <v-dialog v-model="loginDialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span>ログイン</span>
        </v-card-title>
        <v-card-actions>
          <!-- 新規登録モーダルへ切り替え -->
          <v-btn @click="openResisterModal">新規登録はこちら</v-btn>
          <!-- モーダルを閉じる -->
          <v-btn @click="closeLoginModal">TOPへ戻る</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- ▲▲▲ログイン画面モーダルここまで▲▲▲ -->

    <!-- ▼▼▼新規登録モーダル▼▼▼ -->
    <v-dialog v-model="resisterDialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span>新規登録</span>
        </v-card-title>
        <v-card-actions>
          <!-- ログインモーダルへ切り替え -->
          <v-btn @click="openLoginModal">ログイン画面へ戻る</v-btn>
          <!-- モーダルを閉じる -->
          <v-btn @click="closeResisterModal">TOPへ戻る</v-btn>

          <!-- 新規登録へのリンク -->
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- ▲▲▲新規登録モーダルここまで▲▲▲ -->

  </v-layout>
</template>


<script>
export default {
  data: () => ({
    loginDialog: false,
    resisterDialog: false
  }),

  created() {},

  methods: {
    openLoginModal: function() {
      this.resisterDialog = false;
      this.loginDialog = true;
    },
    closeLoginModal: function() {
      this.loginDialog = false;
    },
    openResisterModal: function() {
      this.resisterDialog = true;
      this.loginDialog = false;
    },
    closeResisterModal: function() {
      this.resisterDialog = false;
    }
  }
};
</script>

<style scoped></style>
