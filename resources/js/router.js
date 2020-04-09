import Vue from "vue";
import VueRouter from "vue-router";

// ページコンポーネントをインポート
import Top from "./components/pages/Top.vue";
import Hero from "./components/pages/Hero.vue";
import Read from "./components/pages/Read.vue";
import WriteStoryPaper from "./components/pages/WriteStoryPaper.vue";
import Profile from "./components/pages/Profile.vue";
import Writedbooks from "./components/pages/profiles/Writedbooks.vue";
import Writingbooks from "./components/pages/profiles/Writingbooks.vue";
import ReadFirstSentence from "./components/pages/ReadFirstSentence.vue";
import WriteFirstSentence from "./components/pages/WriteFirstSentence.vue";
import EditPaperNovel from "./components/pages/EditPaperNovel.vue";
import WriteTitlePaper from "./components/pages/WriteTitlePaper.vue";

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
        path: "/write-first-sentence/:hero_id",
        component: WriteFirstSentence,
        name: "WriteFirstSentence",
    },
    {
        path: "/write-story-paper/:hero_id/:user_paper_order",
        component: WriteStoryPaper,
        name: "WriteStoryPaper",
    },
    {
        path: "/edit-paper-novel/:user_paper_order",
        component: EditPaperNovel,
        name: "EditPaperNovel",
    },
    {
        path: "/write/title/:user_paper_order",
        component: WriteTitlePaper,
        name: "WriteTitlePaper",
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
