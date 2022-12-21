<template>
    <v-app id="inspire">
       <v-content>
          <v-container fluid fill-height>
             <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                   <v-card class="elevation-12">
                      <v-toolbar dark color="primary">
                         <v-toolbar-title>Profile</v-toolbar-title>
                      </v-toolbar>
                      <v-card-text>
                         <v-form>
                            <v-text-field
                               v-model="user.username"
                               name="username"
                               label="Username"
                               type="text"
                               disabled
                            ></v-text-field>
                            <v-text-field
                               v-model="user.nama_user"
                               name="nama_user"
                               label="nama user"
                               type="text"
                               disabled
                            ></v-text-field>
                            <v-text-field
                               v-model="user.telepon"
                               name="telepon"
                               label="telepon"
                               type="text"
                               disabled
                            ></v-text-field>
                            <v-text-field
                               v-model="user.email"
                               name="email"
                               label="email"
                               type="text"
                               disabled
                            ></v-text-field>
                         </v-form>
                      </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="logout">Log Out</v-btn>
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
     let user = ref([])
     
     const usr = reactive({
                username: "",
                nama_user: "",
                telepon: "",
                email: ""
        });
     const router = useRouter()
     const validation = ref([]);
     onMounted(() => {
            let id=localStorage.getItem("id_user");
            let token=localStorage.getItem("token");
            axios.get(`https://japaeku.com/laravel_kelompokC/public/api/users/${id}`, {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                user.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        })
        function logout(){
            localStorage.removeItem("token");
            localStorage.removeItem("id_user");
            router.push({ name: 'Login' });
        }
     return {
       user,
       logout
     };
   },
 };
 </script>
 
 <style></style>
 