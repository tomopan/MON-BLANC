import Vue from "vue";
import VueRouter from "vue-router";

// ページコンポーネントをインポート
import Top from "./components/pages/Top.vue";
import Hero from "./components/pages/Hero.vue";
import ReadPaper from "./components/pages/ReadPaper.vue";
import WriteStoryPaper from "./components/pages/WriteStoryPaper.vue";
import Profile from "./components/pages/Profile.vue";
import PaperNovelOpened from "./components/pages/profiles/PaperNovelOpened.vue";
import PaperNovelClosed from "./components/pages/profiles/PaperNovelClosed.vue";
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
        path: "/write-first-sentence/:hero_id/",
        component: ReadFirstSentence,
        name: "ReadFirst",
    },
    {
        path: "/read-paper/:hero_id/:paper_novel_id",
        component: ReadPaper,
        name: "ReadPaper",
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
        redirect: "/profile/PaperNovelOpened",
        children: [
            {
                path: "/profile/PaperNovelOpened",
                component: PaperNovelOpened,
                name: "PaperNovelOpened",
            },
            {
                path: "/profile/PaperNovelClosed",
                component: PaperNovelClosed,
                name: "PaperNovelClosed",
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
