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
                        <v-btn color="primary" @click="clickEdit">Edit</v-btn>
                     </v-card-actions>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="logout">Log Out</v-btn>
                     </v-card-actions>

                     
        <v-dialog transition="dialog-top-transition" max-width="600" v-model="dialogEdit" style="border-radius: 10px;">
            <v-card>
                <v-card-title>
                    <span class="headline"> Edit Reservasi </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                            <v-text-field
                               v-model="user.username"
                               name="username"
                               label="Username"
                               type="text"
                            ></v-text-field>
                            <v-text-field
                               v-model="user.nama_user"
                               name="nama_user"
                               label="nama user"
                               type="text"
                            ></v-text-field>
                            <v-text-field
                               v-model="user.telepon"
                               name="telepon"
                               label="telepon"
                               type="text"
                            ></v-text-field>
                            <v-text-field
                               v-model="user.email"
                               name="email"
                               label="email"
                               type="text"
                            ></v-text-field>
                        </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelEdit"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="edit(user.id)"> Save</v-btn>
                </v-card-actions>
            </v-card>
                </v-dialog>
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
    data(){
        return{
            dialogEdit: false,
        }
    },
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
        function edit(id){
            let username = this.user.username
            let nama_user = this.user.nama_user
            let telepon = this.user.telepon
            let email = this.user.email
            let token=localStorage.getItem("token");
        axios.put(`https://japaeku.com/laravel_kelompokC/public/api/users/${id}`,{
                    username: username,
                    nama_user: nama_user,
                    telepon: telepon,
                    email: email
            },{
                headers: {
                Authorization: `Bearer ${token}`
                }
            })
      .then(() => {
                location.reload();
        })
        .catch((error) => {
         validation.value = error.response.data;
         console.log(error.response.data);
        });
    }
     return {
       user,
       edit,
       logout
     };
   },
   methods :{
    
    clickEdit(item){
            this.dialogEdit = true;

        },
        resetForm() {
            this.usr = {
                username: null,
                nama_user: null,
                telepon: null,
                gender: null
            };
        },
        cancelEdit(){
            this.resetForm();
            this.dialogEdit = false;
        },
   }
 };
 </script>
 
 <style></style>
 