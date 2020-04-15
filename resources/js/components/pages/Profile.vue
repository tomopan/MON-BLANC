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
                    <v-btn  @click="getProfilData">戻る</v-btn>
                    <v-btn  @click="editUserData">更新</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-layout>
        <!--  テスト -->
        
        <!-- モーダルここまで -->
        <v-row>
            <v-col>
                <v-row>
                    <v-col>
                        <p>{{ loginUser.name }} さんのマイページです</p>
                        <p>@{{loginUser.user_name}}</p>
                    </v-col>
                    <v-btn icon @click.native.stop="dialog =  true">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </v-row>
                <!-- 紹介文 -->
                <v-divider></v-divider>
                <p v-if="loginUser.bio" class="bio_text">{{loginUser.bio}}</p>
                <p v-else class="bio_text">紹介文を書いてみましょう</p>
                <v-divider></v-divider> 
                <!-- 紹介文ここまで -->

            </v-col>
            <v-col>
                <v-avatar size="100"> </v-avatar>
            </v-col>
        </v-row>
        <!-- 公開/非公開のコンポーネント切り替え -->
        <v-tabs background-color="transparent" color="basil" grow>
            <router-link :to="{ name: 'PaperNovelOpened' }">
                <v-tab>
                    <p>公開中</p>
                </v-tab>
            </router-link>
            <router-link :to="{ name: 'PaperNovelClosed' }">
                <v-tab>
                    <p>非公開</p>
                </v-tab>
            </router-link>
            <router-link :to="{ name: 'MarkedText' }">
                <v-tab>
                    <p>マーカー</p>
                </v-tab>
            </router-link>
        </v-tabs>
        <router-view></router-view>

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
            openNovels: [],
            closeNovels: [],
            dialog: false,
            postUserData:{}
        };
    },
    created() {
        this.getLoginUserData();
        this.getProfilData();
    },
    computed: {
        ...mapGetters(["loginUser"]),
    },
    methods: {
        //ログインしているユーザーの情報
        ...mapActions(["getLoginUserData"]),
        //プロフィール情報の取得
        getProfilData:function(){
            axios
                .get("api/get/user")
                .then(res => {
                    this.postUserData.name = res.data.name;
                    this.postUserData.user_name = res.data.user_name;
                    this.postUserData.bio = res.data.bio;
                    console.log(this.postUserData)
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            this.dialog =false;
        },
        //プロフィールを編集
        editUserData: function() {
            console.log(this.postUserData)
            axios
                .post("api/edit/user",this.postUserData)
                .then(res => {
                    console.log(res)
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            this.dialog =false;
            this.getLoginUserData();
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
