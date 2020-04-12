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
}
</style>