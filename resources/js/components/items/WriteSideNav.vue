<template>
  <!-- <v-card> -->
    <v-navigation-drawer
        v-model="drawer"
        :mini-variant.sync="mini"
        absolute
        margin-top:30px
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="https://assets.st-note.com/production/uploads/images/17220311/rectangle_large_type_2_e0050b10549e41bb8deb5a3d00e732d4.jpeg?fit=bounds&format=jpeg&quality=45&width=960"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>ルネ・デカルト</v-list-item-title>

        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  <!-- </v-card> -->
</template>


<script>
  export default {
    data () {
      return {
        drawer: true,
        items: [
          { title: 'Home', icon: 'mdi-home-city' },
          { title: 'My Account', icon: 'mdi-account' },
          { title: 'Users', icon: 'mdi-account-group-outline' },
        ],
        mini: false,
      }
    },
  }
</script>

<style scoped>

</style>  