<template>
    <v-container>
        <!-- モーダル -->
        <v-layout row justify-center>
            <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title>
                <span class="headline">プロフィールを編集</span>
                </v-card-title>
                <v-card-text>
                <v-container>
                    <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field label="Name" v-model="postUserData.name" required></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="User Name" v-model="postUserData.user_name" required></v-text-field>
                    </v-flex>
                    <v-flex xs8>
                        <v-text-field  label="Bio" v-model="postUserData.bio" multi-line></v-text-field>
                    </v-flex>
                    </v-layout>
                </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn  @click="getProfileData">戻る</v-btn>
                    <v-btn  @click="editUserData">更新</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-layout>
        <!-- モーダルここまで -->

        <!-- プロフィール表示 -->
        <v-row>
            <v-col>
                <v-row>
                    <v-col>
                        <p>{{ profileData.name }} さんのプロフィールです</p>
                        <p>@{{profileData.user_name}}</p>
                    </v-col>
                    <v-btn 
                        v-if="profileData.user_name == loginUser.user_name"
                        icon @click="openEditModal"
                    >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </v-row>
                <!-- 紹介文 -->
                <v-divider></v-divider>
                <p v-if="loginUser.bio" class="bio_text">{{profileData.bio}}</p>
                <p v-else class="bio_text">紹介文を書いてみましょう</p>
                <v-divider></v-divider> 
                <!-- 紹介文ここまで -->

            </v-col>
            <v-col>
                <v-avatar size="100"> </v-avatar>
            </v-col>
        </v-row>
        <!-- 公開/非公開のコンポーネント切り替え -->
        <v-tabs
        background-color="transparent" color="basil" grow>
            <router-link :to="{ name: 'PaperNovelOpened' }" >
                <v-tab>
                    <p>公開中</p>
                </v-tab>
            </router-link>
            <router-link 
            v-if="profileData.user_name == loginUser.user_name"
            :to="{ name: 'PaperNovelClosed' }">
                <v-tab>
                    <p>非公開</p>
                </v-tab>
            </router-link>
            <router-link 
            v-if="profileData.user_name == loginUser.user_name"
            :to="{ name: 'MarkedText' }">
                <v-tab>
                    <p>マーカー</p>
                </v-tab>
            </router-link>
        </v-tabs>
        <router-view :loginUserName="loginUser.user_name"></router-view>
        <!-- 書いた小説を表示 -->
    </v-container>
</template>

<!-- 以下にscript/cssを記述 -->
<script>
// インポート
import { mapActions, mapGetters } from "vuex";
// Vueの処理
export default {
    components: {},
    data() {
        return {
            //プロフィールデータ
            profileData:{},
            //編集する際にpostするデータ
            postUserData:{},
            dialog: false,
        };
    }, 
    watch: {
        '$route' (to, from) {
        // ルートの変更の検知
            if (to.path !== from.path) {
                this.getLoginUserData();
                this.getProfileData(to.params.user_name);
            }
        },
    },
    created() {
        this.getLoginUserData();
        this.getProfileData(this.$route.params.user_name);
    },
    computed: {
        ...mapGetters(["loginUser"]),
    },
    methods: {
        //ログインしているユーザーの情報
        ...mapActions(["getLoginUserData"]),
        //プロフィール情報の取得
        getProfileData:function(user_name){
            console.log(user_name)
            axios
                .get("api/get/user_profile/" + user_name)
                .then(res => {
                    this.$set(this.profileData, "name", res.data.name);
                    this.$set(this.profileData, "user_name",  res.data.user_name);
                    this.$set(this.profileData, "bio", res.data.bio);
                    // // this.profileData.name = res.data.name;
                    // this.profileData.user_name = res.data.user_name;
                    // this.profileData.bio = res.data.bio;
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            this.dialog =false;
        },
        //プロフィールを編集
        editUserData: function() {
            axios
                .post("api/edit/user",this.postUserData)
                .then(res => {
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            this.dialog =false;
            this.getLoginUserData();
        },
        //プロフィール編集のモーダルを開く
        openEditModal:function(){
            this.dialog = true;
            this.postUserData.name = this.loginUser.name;
            this.postUserData.user_name = this.loginUser.user_name;
            this.postUserData.bio = this.loginUser.bio;
        }
    },
};
</script>

<style scoped>
*:focus {
outline: none;
}

p{
    color: #333;
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;

}
a:hover{
    text-decoration: none;
}

</style>
