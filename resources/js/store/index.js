import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
// import heroesModule from "./heroes";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        // heroes: heroesModule,
    },
    state: {
        loginUser: "",
        login: false,
        HeroData: "",
        drawerLoginModal:false,
    },
    mutations: {
        setLoginUser(state, loginUser) {
            state.loginUser = loginUser;
            if(loginUser)state.login = true;
        },
        setHero(state, HeroData) {
            state.HeroData = HeroData;
        },
        toggleLoginModal(state) {
            state.drawerLoginModal = !state.drawerLoginModal;
        }
    },
    actions: {
        getLoginUserData({ commit }) {
            axios.get("api/get/user").then(res => {
                commit("setLoginUser", res.data);
            });
        },
        fetchHeroData({ commit }, hero_id) {
            axios.get("api/get/hero_fetch/" + hero_id).then(res => {
                commit("setHero", res.data);
            });
        },
        toggleLoginModal({ commit }) {
            commit("toggleLoginModal");
        }
    },
    getters: {
        loginUser: state => state.loginUser,
        HeroData: state => state.HeroData
    }
});
