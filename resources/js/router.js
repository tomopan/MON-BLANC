import Vue from "vue";
import VueRouter from "vue-router";

// ページコンポーネントをインポート
import Top from './components/pages/Top.vue';
import Hero from './components/pages/Hero.vue';
import Read from './components/pages/Read.vue';
import Write from './components/pages/Write.vue';
import HeroDetail from './components/pages/HeroDetail.vue';
import Profile from './components/pages/Profile.vue';
import Bookmark from './components/pages/profiles/Bookmark.vue';
import Bookshelf from './components/pages/profiles/Bookshelf.vue';
import Writedbooks from './components/pages/profiles/Writedbooks.vue';
import Writingbooks from './components/pages/profiles/Writingbooks.vue';
import Episodes from './components/pages/Episodes.vue';


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Top,
        name:"Top"
    },
    {
        path: '/hero',
        component: Hero,
        name:"Hero",
    },
    {
        path: '/herodetail',
        component: HeroDetail,
        name:"HeroDetail"
    },
    {
        path: '/read',
        component: Read,
        name:"Read"
    },
    {
        path: '/write',
        component: Write,
        name:"Write"
    },
    {
        path: '/episodes',
        component: Episodes,
        name:"Episodes"
    },
    {
        path: '/profile',
        component: Profile,
        name:"Profile",
        children: [
            {
                path: "/profile/bookshelf",
                component: Bookshelf,
                name: "Bookshelf"
            },
            {
                path: "/profile/bookmark",
                component: Bookmark,
                name: "Bookmark"
            },
            {
                path: "/profile/writedbooks",
                component: Writedbooks,
                name: "Writedbooks"
            },
            {
                path: "/profile/writingbooks",
                component: Writingbooks,
                name: "Writingbooks"
            }
        ]
    },
];


// VueRouterインスタンスを作成する
const router = new VueRouter({
    routes
  })

// app.jsでインポートするため
export default router

// export default new VueRouter({ routes });