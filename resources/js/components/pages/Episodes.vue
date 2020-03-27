<template>
    <v-container>
        <v-row>
            <v-img max-width="100" src="https://assets.st-note.com/production/uploads/images/17220311/rectangle_large_type_2_e0050b10549e41bb8deb5a3d00e732d4.jpeg?fit=bounds&format=jpeg&quality=45&width=960"
            aspect-ratio="1.4"></v-img>
            <div>
                <h1>『{{novel_title}}』</h1>
                <p>{{user_id}}</p>
                <FollowBtnComponent/>
            </div>
        </v-row>
        <br>
        <h1>目次</h1>
        <!-- ライン -->
        <v-divider></v-divider>
        <br>
        <v-row>
        <router-link :to="{ name: 'Read'}">
        <p>第{{episode_number}}話　{{episode_title}}</p>
        </router-link>
        </v-row>
        <!-- ここから目次 -->  
        

    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import FollowBtnComponent from "../items/FollowBtnComponent.vue";


// Vueの処理
export default {
  components: {
      FollowBtnComponent
  },
  data() {
    return {
        name:"かわべ",
        user_id:"@kawabe",
        follower_count:77,
        follow_count:777,
        novel_title:"風の歌を聴け",
        episode_title:"",
        episode_number:null,
    };
  },

  created() {
    this.showNovelInfo();
    this.showEpisodeInfo();
  },
  methods: {
    showNovelInfo:function(){
    //Novelテーブルから情報を取得
        axios
        .get("api/get/novel/")
        .then(res => {
            this.novel_title =res.data[0].title;
            console.log(res.data[0].title);
        })
        .catch(err => {
            console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜
        })
    },
    showEpisodeInfo:function(){
    //Episodesテーブルから情報を取得
        axios
        .get("api/get/episode/")
        .then(res => {
            this.episode_title =res.data[0].episode_title;
            this.episode_number =res.data[0].episode_number;
            this.text =res.data[0].text;
            console.log(res.data[0]);
        })
        .catch(err => {
            console.log(err.response.data);　//ここにエラーの箇所とどんなエラーなのか書いてあります〜
        })
    }
  }
};
</script>



<style scoped>

</style>