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
import MarkedText from "./components/pages/profiles/MarkedText.vue";
import ReadFirstSentence from "./components/pages/ReadFirstSentence.vue";
import WriteFirstSentence from "./components/pages/WriteFirstSentence.vue";
import EditPaperNovel from "./components/pages/EditPaperNovel.vue";
import WriteTitlePaper from "./components/pages/WriteTitlePaper.vue";
import EditStoryPaper from "./components/pages/EditStoryPaper.vue";

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
        path: "/read-first-sentence/:hero_id/",
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
        path: "/write-story-paper/:user_paper_order/:story_number",
        component: WriteStoryPaper,
        name: "WriteStoryPaper",
    },
    {
        path: "/edit-paper-novel/:user_paper_order",
        component: EditPaperNovel,
        name: "EditPaperNovel",
    },
    {
        path: "/write-title/:user_paper_order",
        component: WriteTitlePaper,
        name: "WriteTitlePaper",
    },
    {
        path: "/edit-story-paper/:user_paper_order/:story_number",
        component: EditStoryPaper,
        name: "EditStoryPaper",
    },
    {
        path: "/profile/:user_name",
        component: Profile,
        name: "Profile",
        redirect: "/profile/:user_name/PaperNovelOpened",
        children: [
            {
                path: "/profile/:user_name/PaperNovelOpened",
                component: PaperNovelOpened,
                name: "PaperNovelOpened",
            },
            {
                path: "/profile/:user_name/PaperNovelClosed",
                component: PaperNovelClosed,
                name: "PaperNovelClosed",
            },
            {
                path: "/profile/:user_name/marker",
                component: MarkedText,
                name: "MarkedText",
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
