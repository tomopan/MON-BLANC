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
                                    <v-text-field
                                        label="Name"
                                        v-model="postUserData.name"
                                        required
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                        label="User Name"
                                        v-model="postUserData.user_name"
                                        required
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs8>
                                    <v-text-field
                                        label="Bio"
                                        v-model="postUserData.bio"
                                        multi-line
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click.native.stop="dialog = false">戻る</v-btn>
                        <v-btn @click="editUserData">更新</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
        <!-- モーダルここまで -->
        <!-- プロフィール表示 -->
        <div class="prpfile_area">
            <div class="icon">
                <v-img src="img/profile-icons/duck.png"></v-img>
            </div>
            <div class="profile_right">
                <div class="text">
                    <p>{{ profileData.name }} @{{ profileData.user_name }}</p>
                    <p v-if="loginUser.bio" class="bio_text">
                        {{ profileData.bio }}
                    </p>
                    <p v-else class="bio_text">紹介文を書いてみましょう</p>
                </div>
                <!-- マイページだったらタブを表示 -->
                <div id="tabs">
                    <v-tabs
                        v-if="profileData.user_name == loginUser.user_name"
                        v-model="active_tab"
                        slider-color="#333"
                    >
                        <div v-for="tab of tabs" :key="tab.id">
                            <router-link
                                v-if="tab.id == 1"
                                :to="{ name: 'PaperNovelOpened' }"
                            >
                                <v-tab class="tab_text">{{ tab.name }}</v-tab>
                            </router-link>
                            <router-link
                                v-else-if="tab.id == 2"
                                :to="{ name: 'PaperNovelClosed' }"
                            >
                                <v-tab class="tab_text">{{ tab.name }}</v-tab>
                            </router-link>
                            <router-link
                                v-else-if="tab.id == 3"
                                :to="{ name: 'openEditModal' }"
                            >
                                <v-tab class="tab_text">{{ tab.name }}</v-tab>
                            </router-link>
                        </div>
                    </v-tabs>
                </div>
            </div>

            <!-- マイページだったらログアウト/編集ボタンを表示 -->
            <div
                v-if="profileData.user_name == loginUser.user_name"
                style="margin-top:100px"
            >
                <v-btn icon @click="openEditModal">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon @click="logout" id="logout_btn">
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </div>
        </div>

        <v-divider></v-divider>
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
            profileData: {},
            //編集する際にpostするデータ
            postUserData: {},
            //モーダルの開閉
            dialog: false,
            //タブ関係
            active_tab: 0,
            tabs: [
                { id: 1, name: "投稿作品" },
                { id: 2, name: "編集中" },
                { id: 3, name: "設定" }
            ]
        };
    },
    watch: {
        $route(to, from) {
            // ルートの変更の検知
            if (to.path !== from.path) {
                this.getLoginUserData();
                this.getProfileData(to.params.user_name);
            }
        }
    },
    created() {
        this.getLoginUserData();
        this.getProfileData(this.$route.params.user_name);
    },
    mounted() {
        //アクティブなタブをパスと同じにする
        const route = this.$route.path.split("/");
        if (route[3] == "PaperNovelClosed") this.active_tab = 1;
        else if (route[3] == "marker") this.active_tab = 2;
        else if (route[3] == "bookmark") this.active_tab = 3;
    },
    computed: {
        ...mapGetters(["loginUser"])
    },
    methods: {
        //ログインしているユーザーの情報
        ...mapActions(["getLoginUserData"]),
        //プロフィール情報の取得
        getProfileData: function(user_name) {
            axios
                .get("api/get/user_profile/" + user_name)
                .then(res => {
                    this.$set(this.profileData, "name", res.data.name);
                    this.$set(
                        this.profileData,
                        "user_name",
                        res.data.user_name
                    );
                    this.$set(this.profileData, "bio", res.data.bio);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });
            this.dialog = false;
        },
        //プロフィールを編集
        editUserData: function() {
            axios
                .post("api/edit/user", this.postUserData)
                .then(res => {
                    this.$set(this.profileData, "name", res.data.name);
                    this.$set(
                        this.profileData,
                        "user_name",
                        res.data.user_name
                    );
                    this.$set(this.profileData, "bio", res.data.bio);
                })
                .catch(err => {
                    console.log(err.response.data); //ここにエラーの箇所とどんなエラーなのか書いてあります〜（添付画像参照）
                });

            //パスを編集後のデータに変更
            this.$router
                .push({
                    name: "Profile",
                    params: {
                        user_name: this.postUserData.user_name
                    }
                })
                .catch(err => {
                    console.log(err.response);
                });
            //モーダルを閉じる
            this.dialog = false;
            //表示を編集後のデータに変更
        },
        //プロフィール編集のモーダルを開く
        openEditModal: function() {
            this.dialog = true;
            this.postUserData.name = this.profileData.name;
            this.postUserData.user_name = this.profileData.user_name;
            this.postUserData.bio = this.profileData.bio;
        },
        //ログアウト
        logout: function() {
            axios
                .post("logout")
                .then(res => {
                    location.href = "/";
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

#app > div > main > div {
    background-image: url(/img/profile/backgroundWhite.png) !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-color: #fff !important;
    width: 930px;
}

p {
    color: #333;
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "Yu Mincho Light",
        "YuMincho", "Yu Mincho", "游明朝体", sans-serif;
}
a:hover {
    text-decoration: none;
}
#logout_btn {
    /* right: 0; */
}
.icon {
    width: 300px;
}
.text {
    margin: 100px auto 0 auto;
    width: 500px;
}

.container {
    margin-bottom: 5em;
}

.v-divider {
    width: 800px;
    margin: 0 auto;
    border-color: #b6bcd6 !important;
    border-width: 3px 0 0 0;
}

.prpfile_area {
    display: flex;
}
.tab_text {
    font-size: 20px;
    color: #333;
}
.v-tab {
    margin: 0;
}

@media screen and (max-width: 480px) {
body{
  font-size:80%;
}

#app > div > main > div > div.prpfile_area > div.icon{
  width: 2em;
}
#app > div > main > div > div.prpfile_area > div.icon > div > div.v-responsive__content{
  width:30px;
}
#app > div > main > div > hr.v-divider{
  margin-top:1em;
}
#tabs > div > div > div.v-slide-group__wrapper > div > div > a > div
{
  font-size:90%;
}
#tabs > div > div > div.v-slide-group__wrapper > div > div,
#tabs > div > div > div.v-slide-group__wrapper > div,
#tabs > div,
#tabs{
  height:30px;
}
#app > div > main > .container{
  width:100%;
}

}
</style>
