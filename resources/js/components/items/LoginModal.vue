<template>
    <v-layout row justify-center>
        <!-- ▼▼▼ログイン画面モーダル▼▼▼ -->
        <v-dialog
            v-model="$store.state.drawerLoginModal"
            max-width="500px"
            persistent
        >
            <v-card>
                <v-btn
                    icon
                    color="#000"
                    @click="
                        $store.state.drawerLoginModal = false;
                        $router.push({ name: 'Top' });
                    "
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>

                <v-card-title>
                    <div>
                        <img
                            :src="'/img/lp/welcome.png'"
                            class="img welcome"
                            alt="welcom"
                        />
                    </div>
                    <div>
                        <img
                            :src="'/img/lp/logo.png'"
                            class="img logo"
                            alt="logo"
                        />
                    </div>
                </v-card-title>
                <v-card-actions>
                    <v-container>
                        <v-row>
                            <v-col cols="9">
                                <v-text-field
                                    label="メールアドレス"
                                    required
                                    v-model="email"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="errors.email"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <v-text-field
                                    label="パスワード"
                                    type="password"
                                    required
                                    v-model="password"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="errors.password"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <p class="link">
                                    <a href="#" class="link"
                                        >パスワードを忘れた場合</a
                                    >
                                </p>
                            </v-col>

                            <button
                                class="button btn01"
                                cols="9"
                                @click="postLogin"
                            >
                                <a href="#" class="btnlink">ログイン</a>
                            </button>
                            <!-- <p class="sentence">または</p>
              <button class="button btn02" cols="9">
                <a href="#" class="btnlink">Twitterでログイン</a>
              </button> -->

                            <!-- 新規登録モーダルへ切り替え -->
                            <div class="signup">
                                <hr align="center" />
                                <p class="sentence">
                                    MonBlancを始めて利用する場合
                                </p>
                                <p @click="openResisterModal" class="sentence">
                                    <a href="#" class="sign">会員登録をする</a>
                                </p>
                            </div>
                            <!-- モーダルを閉じる -->
                            <!-- <v-btn @click="closeLoginModal">TOPへ戻る</v-btn> -->
                        </v-row>
                    </v-container>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- ▲▲▲ログイン画面モーダルここまで▲▲▲ -->

        <!-- ▼▼▼新規登録モーダル▼▼▼ -->
        <v-dialog v-model="resisterDialog" max-width="500px" persistent>
            <v-card>
                <v-btn
                    icon
                    color="#000"
                    @click="
                        $store.state.drawerLoginModal = false;
                        resisterDialog = false;
                    "
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-card-title>
                    <div>
                        <img
                            :src="'/img/lp/welcome.png'"
                            class="img welcome"
                            alt="welcom"
                        />
                    </div>
                    <div>
                        <img
                            :src="'/img/lp/logo.png'"
                            class="img logo"
                            alt="logo"
                        />
                    </div>
                </v-card-title>
                <v-card-actions>
                    <v-container>
                        <v-row>
                            <v-col cols="9">
                                <v-text-field
                                    label="メールアドレス"
                                    required
                                    v-model="newEmail"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="regiErrors.email"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <v-text-field
                                    label="名前"
                                    type="text"
                                    required
                                    v-model="newName"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="regiErrors.name"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <v-text-field
                                    label="ユーザーID"
                                    type="text"
                                    required
                                    v-model="newUserId"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="regiErrors.user_name"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <v-text-field
                                    label="パスワード"
                                    type="password"
                                    required
                                    v-model="newPassword"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="regiErrors.password"
                                >
                                    必須項目です
                                </div>
                            </v-col>
                            <v-col cols="9">
                                <v-text-field
                                    label="パスワード確認"
                                    type="password"
                                    required
                                    v-model="newPasswordConfirmation"
                                ></v-text-field>
                                <div
                                    class="alert alert-danger"
                                    v-if="regiErrors.password"
                                >
                                    正しくありません
                                </div>
                            </v-col>

                            <button
                                class="button btn01 signin"
                                cols="9"
                                @click="postRegister"
                            >
                                <a href="#" class="btnlink">会員登録</a>
                            </button>
                            <!-- <p class="sentence">または</p>
                            <button class="button btn02" cols="9">
                                <a href="#" class="btnlink"
                                    >Twitterでログイン</a
                                >
                            </button> -->

                            <!-- ログインモーダルへ切り替え -->
                            <div class="signup">
                                <hr align="center" />
                                <p class="sentence">
                                    すでにアカウントをお持ちの場合
                                </p>
                                <p @click="openLoginModal" class="sentence">
                                    <a href="#" class="sign">ログインをする</a>
                                </p>
                            </div>

                            <!-- モーダルを閉じる -->
                            <!-- <v-btn @click="closeResisterModal">TOPへ戻る</v-btn> -->
                        </v-row>
                    </v-container>
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
        resisterDialog: false,
        email: "",
        password: "",
        newEmail: "",
        newPassword: "",
        newName: "",
        newUserId: "",
        newPasswordConfirmation: "",
        errors: {},
        regiErrors: {}
    }),

    created() {},

    methods: {
        openLoginModal: function() {
            this.resisterDialog = false;
            this.$store.state.loginDialog = true;
        },
        closeLoginModal: function() {
            this.loginDialog = false;
        },
        openResisterModal: function() {
            this.resisterDialog = true;
            this.$store.state.loginDialog = false;
        },
        closeResisterModal: function() {
            this.resisterDialog = false;
        },
        postLogin() {
            axios
                .post(window.location.origin + `/login`, {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    window.location.href = window.location.origin + '#'+ this.$route.path;
                    this.$store.state.drawerLoginModal = false;
                    this.$store.state.login =true;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors);
                    console.log(error)
                });
        },
        postRegister() {
            axios
                .post(window.location.origin + `/register`, {
                    email: this.newEmail,
                    password: this.newPassword,
                    password_confirmation: this.newPasswordConfirmation,
                    name: this.newName,
                    user_name: this.newUserId
                })
                .then(response => {
                    window.location.href = window.location.origin + `/`;
                })
                .catch(error => {
                    this.regiErrors = error.response.data.errors;
                    console.log(this.regiErrors);
                });
        }
    }
};
</script>

<style scoped>
*:focus {
    outline: none;
}

.v-card__title {
    display: flex;
    flex-direction: column;
}
.welcome {
    width: 10em;
}
.logo {
    width: 12em;
}
.row {
    display: flex;
    flex-direction: column;
}
label {
    left: 0.4em;
    color: #707070;
}
.link {
    font-size: 12px;
    margin-bottom: 0;
}
.sentence {
    font-size: 12px;
    text-align: center;
    margin-bottom: 0;
}
.v-dialog > .v-card > .v-card__title {
    padding-bottom: 0;
}
.btn01 {
    background: #ffce98;
    border: none;
    border-radius: 30px;
    color: #707070;
    padding: 5px 0;
    width: 22em;
    margin: 1em auto;
}
.btn01:hover {
    background: #dbb183;
}
.btn02 {
    background: #c9eff5;
    border: none;
    border-radius: 30px;
    color: #707070;
    padding: 5px 0;
    width: 22em;
    margin: 1em auto;
}
.btn02:hover {
    background: rgb(162, 191, 196);
}
hr {
    max-width: 150px;
    margin-left: auto;
    margin-right: auto;
}
.link,
.btnlink {
    color: #000;
}
.link:hover {
    color: rgb(252, 163, 68);
    text-decoration: none;
}
.btnlink {
    text-decoration: none;
}
.sign {
    color: rgb(252, 163, 68);
}
.sign:hover {
    color: rgb(253, 194, 131);
    text-decoration: none;
}
.signin {
    margin-top: 2em;
}

@media screen and (max-width: 415px) {
    .button {
        width: 250px;
        margin: 0.8em auto 0.5em;
    }
}
</style>

<style>
.v-text-field input,
.v-input input,
.v-input__slot input {
    border-radius: 10px;
    border: 1px solid #bdbdbd;
}
.v-text-field input {
    margin-top: 0.3em;
}

.v-dialog,
.v-dialog--active {
    border-radius: 13px;
}
.col-9 {
    padding: 5px;
    margin: 0 auto;
}
.v-input__control {
    height: 2em;
}
.v-text-field > .v-input__control > .v-input__slot:before,
.v-text-field > .v-input__control > .v-input__slot:after {
    border-color: #fff;
    border-style: none;
}
/* #app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(1)
    > div
    > div
    > div.v-input__slot
    > div
    > label,
#app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(2)
    > div
    > div
    > div.v-input__slot
    > div
    > label,
#app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(3)
    > div
    > div
    > div.v-input__slot
    > div
    > label {
    top: 10px;
    margin-left: 5px;
} */
#app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(1)
    > div
    > div
    > div.v-input__slot
    > div
    > label,
#app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(2)
    > div
    > div
    > div.v-input__slot
    > div
    > label,
#app
    > div.v-dialog__content.v-dialog__content--active
    > div
    > div
    > div.v-card__actions
    > div
    > div
    > div:nth-child(3)
    > div
    > div
    > div.v-input__slot
    > div
    > label,
    #app > div:nth-child(5) > div > div > div.v-card__actions > div > div > div:nth-child(4) > div > div > div.v-input__slot > div > label,
    #app > div:nth-child(5) > div > div > div.v-card__actions > div > div > div:nth-child(5) > div > div > div.v-input__slot > div > label{
    top: 10px;
    margin-left: 5px;

    color: #707070 !important;
    caret-color: #707070 !important;
}
</style>
