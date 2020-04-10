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
                <v-btn icon>
                    <v-icon @click="logout">mdi-logout</v-icon>
                </v-btn>
        </v-app-bar>
    </div>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    methods: {
        logout: function() {
            axios
            .post("logout")
            .then(res => {
            location.href = "/";
            })
            .catch(err => console.log(err));
        },
        }
    }
    </script>