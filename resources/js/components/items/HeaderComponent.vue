<template>
    <div>
        <v-app-bar>
            <v-spacer></v-spacer>
            <router-link :to="{ name: 'Top' }" style="text-decoration: none">
                <v-toolbar-title floating="true">
                    <span style="font-size:30px;color:#A39362 ;">Mon Blan</span>
                </v-toolbar-title>
            </router-link>

            <v-spacer></v-spacer>

            <!-- マイページ -->
            <router-link :to="{ name: 'Profile' }">
                <v-btn icon>
                    <v-icon>mdi-home</v-icon>
                </v-btn>
            </router-link>
        </v-app-bar>
    </div>
</template>
