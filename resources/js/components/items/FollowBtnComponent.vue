<template>
    <v-btn class="ma-2" tile outlined 
    @click.stop="isFollowed = !isFollowed">
    フォロー
    <v-icon>mdi-heart</v-icon>
    </v-btn>
</template>

<script>
  export default {
    data: () => ({
      isFollowed:false,
    }),

    // computed: {
    //     completedTasks () {
    //     return this.tasks.filter(task => task.done).length
    //   },
    //   progress () {
    //     return this.completedTasks / this.tasks.length * 100
    //   },
    //   remainingTasks () {
    //     return this.tasks.length - this.completedTasks
    //   },
    // },

    methods: {

    },
  }
</script>