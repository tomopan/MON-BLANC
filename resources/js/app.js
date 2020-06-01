require("./bootstrap");

window.Vue = require("vue");
import vuetify from "./vuetify";
import router from "./router";
import store from "./store/index";
// jQuery
import jQuery from "jquery";
global.jQuery = jQuery;
global.$ = jQuery;
window.$ = window.jQuery = require("jquery");

// turn.js
require("./turn");

// typer
import Typer from "vue-typer/dist/vue-typer";
Vue.use(Typer);

// ルートコンポーネントをインポートする
import App from "./components/App.vue";

const app = new Vue({
    el: "#app",
    router,
    vuetify,
    store,
    Typer,
    components: {
        App
    },
    template: "<App />" // ルートコンポーネントを描画する
});
