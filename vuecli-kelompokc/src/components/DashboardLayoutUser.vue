<template>
    <v-main>
      <link
        href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css"
        rel="stylesheet"
      />
    <div class="dasboard">
        <v-navigation-drawer class="fullheight" width="256" v-model="drawer"
        absolute temporary color="grey lighten-5" >
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">Eric Roberto Djohan</v-list-item-title>
                    <v-list-item-subtitle>200711007</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item v-for="item in items" :key="item.title" link 
                color="light-blue darken-4" tag="router-link" :to="item.to">
                    <v-list-item-content>
                        <v-list-item-title>{{item.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar color="red lighten-3" dark>
            <v-app-bar-nav-icon @click="drawer = true" 
            color="white"></v-app-bar-nav-icon>
            <VSpacer />
        </v-app-bar>
        <div class="fullheight pa-5">
            <router-view></router-view>
        </div>
    </div>
    </v-main>
</template>
<script>
export default {
    name: "Root",
    data() {
        return{
            drawer: false,
            group: null,
            items: [
                {title: "Dashboard", to: "/DashboardLayoutUser"},
                {title: "Reservasi", to: "/rvu"},
                {title: "Produk", to: "/pru"},
            ],
        };
    },
};
</script>
<style scoped>
    .fullheight {
        min-height: 100vh !important;
    }
</style>