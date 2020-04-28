<template>
    <v-app>
        <header-component />
        <main>
            <div>
                <router-view></router-view>
            </div>
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
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;

}
</style>