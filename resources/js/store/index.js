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
        HeroData: "",
    },
    mutations: {
        setLoginUser(state, loginUser) {
            state.loginUser = loginUser;
        },
        setHero(state, HeroData) {
            state.HeroData = HeroData;
        },
    },
    actions: {
        getLoginUserData({ commit }) {
            axios.get("api/get/user").then((res) => {
                commit("setLoginUser", res.data);
            });
        },
        fetchHeroData({ commit }, hero_id) {
            axios.get("api/get/hero_fetch/" + hero_id).then((res) => {
                commit("setHero", res.data);
            });
        },
    },
    getters: {
        loginUser: (state) => state.loginUser,
        HeroData: (state) => state.HeroData,
    },
});
