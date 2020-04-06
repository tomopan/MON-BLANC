require("./bootstrap");

window.Vue = require("vue");
import vuetify from "./vuetify";
import router from "./router";
import store from "./store/index";

// ルートコンポーネントをインポートする
import App from './components/App.vue'

const app = new Vue({
    el: "#app",
    router,
    vuetify,
    store,
    components: {
        App
    },
    template: '<App />' // ルートコンポーネントを描画する
});

