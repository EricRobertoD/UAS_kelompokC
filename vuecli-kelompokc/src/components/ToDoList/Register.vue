<template>
   <v-main>
     <link
       href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css"
       rel="stylesheet"
     />
   <v-app id="inspire">
      <v-content>
         <v-container fluid fill-height>
            <v-layout align-center justify-center>
               <v-flex xs12 sm8 md4>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Register form</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text>
                        <v-form>
                           <v-text-field
                              :error-message="validation.nama_user"
                              v-model="user.nama_user"
                              name="nama"
                              label="Nama"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              :error-message="validation.username"
                              v-model="user.username"
                              name="username"
                              label="Username"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              :error-message="validation.password"
                              v-model="user.password"
                              name="password"
                              label="Password"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              :error-message="validation.email"
                              v-model="user.email"
                              name="email"
                              label="Email"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              :error-message="validation.telepon"
                              v-model="user.telepon"
                              name="telepon"
                              label="Telepon"
                              type="text"
                              required
                           ></v-text-field>
                           <v-select
                              :error-message="validation.gender"
                              v-model="user.gender"
                              :items="jenisKelamin"
                              item-value="id"
                              item-text="nama"
                              name="gender"
                              label="Gender"
                              type="text"
                              required
                           ></v-select>
                        </v-form>
                     </v-card-text>
                     <v-card-actions>
                        <v-snackbar v-model="snackbar.show" :color="snackbar.color" timeout="2000" center bottom>
                           <v-icon left>{{ snackbar.icon }}</v-icon>
                              {{ snackbar.message }}
                              <template v-slot:action="{ attrs }">
                                 <v-btn icon v-bind="attrs" @click="(snackbar.show = false)"><v-icon>mdi-close</v-icon></v-btn>
                              </template>
                        </v-snackbar>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="store">Register</v-btn>
                     </v-card-actions>
                     
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-content>
   </v-app>
   </v-main>
</template>

<script>
import axios from 'axios'
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue2-helpers/vue-router'

export default {
   setup(){
      let jenisKelamin = [
         {
            nama: 'Wanita',
            id: 0
         },
         {
            nama: 'Pria',
            id: 1
         }
      ]
      const snackbar = reactive({
         show: false,
         message: "",
         color: "",
         icon: ""
      })
      const user = reactive({
            nama_user: "",
            username: "",
            password: "",
            email: "",
            telepon: "",
            gender: ""
      });
        const router = useRouter()
    const validation = ref([]);

      function store() {
            let nama_user = user.nama_user
            let username = user.username
            let password = user.password
            let email = user.email
            let telepon = user.telepon
            let gender = user.gender

      axios.post("https://japaeku.com/laravel_kelompokC/public/api/register", {
            nama_user: nama_user,
            username: username,
            password: password,
            email: email,
            telepon: telepon,
            gender: gender,
        })
      .then(() => {
         snackbar.show = true;
         snackbar.color = "green";
         snackbar.message = "Verifikasi Email ya!!";
         snackbar.icon = "mdi-thumb-up";
         router.push({ name: "Login" });
         
        })
        .catch((error) => {
         validation.value = error.response.data;
         snackbar.show = true;
         snackbar.color = "red";
         snackbar.message = "gagal register";
         snackbar.icon = "mdi-alert";
         console.log(error.response.data);
        });
    }

    return {
      snackbar,
      user,
      jenisKelamin,
      validation,
      store,
    }


   }
};
</script>

<style></style>
