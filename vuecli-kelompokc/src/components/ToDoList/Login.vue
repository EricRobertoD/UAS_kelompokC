<template>
   <v-app id="inspire">
      <v-content>
         <v-container fluid fill-height>
            <v-layout align-center justify-center>
               <v-flex xs12 sm8 md4>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Login form</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text>
                        <v-form>
                           <v-text-field
                              v-model="user.username"
                              name="username"
                              label="Username"
                              type="text"
                           ></v-text-field>
                           <v-text-field
                              v-model="user.password"
                              id="password"
                              name="password"
                              label="Password"
                              type="password"
                           ></v-text-field>
                        </v-form>
                     </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="Login">Login</v-btn>
                     </v-card-actions>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <router-link
                        to="/Register"
                        >
                        <v-btn color="primary">Register</v-btn>
                        </router-link>
                    </v-card-actions>

                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-content>
   </v-app>

</template>

<script>
import axios from 'axios'
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue2-helpers/vue-router'

export default {
  setup() {
    const user = reactive({
      username: "",
      password: "",
    });
   const router = useRouter()
    const validation = ref([]);
    // const router = default/();
    // routerlink 
    function Login() {
      let username = user.username;
      let password = user.password;
      axios.post("https://japaeku.com/laravel_kelompokC/public/api/login", {
          username: username,
          password: password,
        })
        .then((response) => {
          let access_token =response.data.access_token;
          let id_user = response.data.user.id;
          localStorage.setItem( 'token', access_token );
          localStorage.setItem( 'id_user',id_user );
          window.dispatchEvent(new CustomEvent('tokenstorage-changed', {
            detail: {
              storage: localStorage.getItem('token'),
              storage2:  localStorage.getItem( 'id_user')

            }
          }));
          console.log(localStorage.getItem('token'));
          console.log( localStorage.getItem('id_user'));
          alert("Berhasil Login");
          console.log(password);
          console.log(username);
          if(username=="admin" && password=="admin"){
            router.push({ name: "admin" })
          }else
          router.push({ name: "user" });

        })
    }

    return {
      user,
      Login,
    };
  },
};
</script>

<style></style>
