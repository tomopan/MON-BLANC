<template>
    <v-container>
        <!-- ユーザープロフィール/実装ではDBから取得してくる -->
        <v-row>
        <v-col>
            <p>{{name}} さん  {{user_id}}</p>
            <p>フォロワー：{{follower_count}}人/フォロー：{{follow_count}}人</p>
        </v-col>
        <v-col>
            <v-avatar
                size=100
                >
            <v-img
                src="https://scontent-nrt1-1.xx.fbcdn.net/v/t1.0-1/41682282_1297327357075527_6743386735356411904_n.jpg?_nc_cat=109&_nc_sid=dbb9e7&_nc_ohc=qqtl9dteVj8AX8S5LSA&_nc_ht=scontent-nrt1-1.xx&oh=2250fde7de4d20824f2dcb52575ebeba&oe=5E8E9CA7" 
            >
            </v-img>
            </v-avatar>
        </v-col>
        </v-row>
        <v-row>
        <router-link :to="{ name: 'Bookshelf'}">
        <p style="color:black"> 本棚</p>
        </router-link>
        /
        <router-link :to="{ name: 'Bookmark'}">
        <p style="color:black">ブックマーク</p>
        </router-link>
        /
        <router-link :to="{ name: 'Writedbooks'}">
            <p style="color:black"> 執筆済み</p>
        </router-link>
        /
        <router-link :to="{ name: 'Writingbooks'}">
            <p style="color:black"> 執筆中</p>
        </router-link>
        </v-row>
        <router-view></router-view>
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート


// Vueの処理
export default {
  components: {

  },
  data() {
    return {
        name:"かわべ",
        user_id:"@kawabe",
        follower_count:77,
        follow_count:777
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