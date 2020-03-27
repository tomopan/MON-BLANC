require("./bootstrap");

window.Vue = require("vue");
import vuetify from "./vuetify";
import router from "./router";

// ルートコンポーネントをインポートする
import App from './components/App.vue'

const app = new Vue({
    el: "#app",
    router,
    vuetify,
    components: {
        App
    },
    template: '<App />' // ルートコンポーネントを描画する
});

