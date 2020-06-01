<template>
    <v-app>
        <header-component />
        <main>
            <router-view></router-view>
        </main>
        <footer-component />
    </v-app>
</template>

<script>
import HeaderComponent from "./items/HeaderComponent.vue";
import FooterComponent from "./items/FooterComponent.vue";

export default {
    components: {
        HeaderComponent,
        FooterComponent
    }
};
</script>

<style>
main{
    color:#333;
    font-family: YuGothic,'Yu Gothic','Yu Gothic UI','Hiragino Sans','ヒラギノ角ゴシック','メイリオ', Meiryo,'ＭＳ Ｐゴシック','MS PGothic',sans-serif;
}

</style>