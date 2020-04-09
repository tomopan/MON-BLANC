import Vue from "vue";
import Vuex from "vuex";
// import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,
    
    // state: {
    //     HeroData: "",
    // },
    // mutations: {
    //     setHero(state, HeroData) {
    //         state.HeroData = HeroData;
    //     },
    // },
    // actions: {
    //     fetchHeroData({ commit }) {
    //         // axios.get("get/hero_fetch/" + $route.params.hero_id).then((res) => {
    //         //     commit("setHero", res.data);
    //         // });
    //         commit("setHero", "智哉" );
    //     },
    // },
    // getters: {
    //     HeroData: (state) => state.HeroData,
    // },
    modules: {
        fetch_hero,
    },
    state: {
        loginUser: "",
    },
    mutations: {
        setLoginUser(state, loginUser) {
            state.loginUser = loginUser;
        },
    },
    actions: {
        testLoginUserData({ commit }) {
            axios.get("api/get/user").then((res) => {
                commit("setLoginUser", res.data);
            });
        },
    },
    getters: {
        loginUser: (state) => state.loginUser,
    },
});
