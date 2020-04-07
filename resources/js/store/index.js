import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        loginUser: "",
    },
    mutations: {
        setLoginUser(state, loginUser) {
            state.loginUser = loginUser;
        },
    },
    actions: {
        getLoginUserData({ commit }) {
            axios.get("api/get/user").then((res) => {
                commit("setLoginUser", res.data);
            });
        },
    },
    getters: {
        loginUser: (state) => state.loginUser,
    },
});
