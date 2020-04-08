import Vue from "vue";
import VueRouter from "vue-router";

// ページコンポーネントをインポート
import Top from "./components/pages/Top.vue";
import Hero from "./components/pages/Hero.vue";
import Read from "./components/pages/Read.vue";
import Write from "./components/pages/Write.vue";
import Profile from "./components/pages/Profile.vue";
import Writedbooks from "./components/pages/profiles/Writedbooks.vue";
import Writingbooks from "./components/pages/profiles/Writingbooks.vue";
import Episodes from "./components/pages/Episodes.vue";
import ReadFirstSentence from "./components/pages/ReadFirstSentence.vue";
import WriteFirstSentence from "./components/pages/WriteFirstSentence.vue";
import PaperEdit from "./components/pages/PaperEdit.vue";
import AddPaper from "./components/pages/AddPaper.vue";
import WriteTitle from "./components/pages/WriteTitle.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: Top,
        name: "Top",
    },
    {
        path: "/hero/:hero_id",
        component: Hero,
        name: "Hero",
    },
    {
        path: "/readfirst/:hero_id/",
        component: ReadFirstSentence,
        name: "ReadFirst",
    },
    {
        path: "/read/:hero_id/:novel_id",
        component: Read,
        name: "Read",
    },
    {
        path: "/write/firstsentence/:hero_id",
        component: WriteFirstSentence,
        name: "WriteFirstSentence",
    },
    {
        path: "/write/paperedit/:user_paper_order",
        component: PaperEdit,
        name: "PaperEdit",
    },
    {
        path: "/write/addpaper/:user_paper_order",
        component: AddPaper,
        name: "AddPaper",
    },
    {
        path: "/write/title/:novel_id",
        component: WriteTitle,
        name: "WriteTitle",
    },
    {
        path: "/write/:hero_id/:user_paper_order",
        component: Write,
        name: "Write",
    },
    {
        path: "/episodes",
        component: Episodes,
        name: "Episodes",
    },
    {
        path: "/profile",
        component: Profile,
        name: "Profile",
        redirect: "/profile/writedbooks",
        children: [
            {
                path: "/profile/writedbooks",
                component: Writedbooks,
                name: "Writedbooks",
            },
            {
                path: "/profile/writingbooks",
                component: Writingbooks,
                name: "Writingbooks",
            },
        ],
    },
];

// VueRouterインスタンスを作成する
const router = new VueRouter({
    routes,
});

// app.jsでインポートするため
export default router;

// export default new VueRouter({ routes });
