<template>
  <div>
    App.vue
    <header-component />
    <main>
        <div class="container">

        <RouterView />
        </div>
    </main>
  </div>
</template>

<script>
import HeaderComponent from './items/HeaderComponent.vue'


export default {
  components: {
    HeaderComponent
  }
}


</script>
