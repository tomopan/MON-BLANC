<template>
    <v-app>
        <header-component />
        <main>
            <div class="container">
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
