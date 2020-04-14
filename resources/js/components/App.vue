<template>
    <v-app>
        <header-component />
        <main>
            <div>
                <RouterView />
            </div>
        </main>
    </v-app>
</template>

<script>
import HeaderComponent from "./items/HeaderComponent.vue";

export default {
    components: {
        HeaderComponent
    }
};
</script>

<style>

main{
    color:#333;
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','Yu Mincho Light','YuMincho','Yu Mincho','游明朝体',sans-serif;

}
</style>