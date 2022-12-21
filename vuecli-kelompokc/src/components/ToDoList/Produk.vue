<template>
    <v-main>
      <link
        href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css"
        rel="stylesheet"
      />
      <v-card elevation="3" class="mt-5 mx-6" style="border-radius: 6px;">
            <v-row justify="center" align="center" style="margin:3px auto;">
                <!-- <v-col>
                    <v-text-field v-model="search" class="font-weight-bold" color="black" style="width: 70%;font-family: Poppins; font-size: 20px; font-style:bold; border-radius: 10px;" rounded append-icon="mdi-magnify" outlined placeholder="Search..." hide-details></v-text-field>
                </v-col> -->
                <v-col>
                    <v-btn class="font-weight-bold" style="margin:10px auto;font-family: Poppins; font-size: 20px; text-transform: capitalize; float:right; color: #ffff" large color="#ff8600" @click="dialog = true">Add Produk</v-btn>
                </v-col>
            </v-row>
        </v-card>
        <v-card elevation="3" style="border-radius: 6px;" class="mt-5 mx-6">
            <v-data-table :headers="headers" :items="produk" :items-per-page="10">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn class="mr-2" outlined color="red lighten-1" icon="" @click="clickEdit(item)"><v-icon color="red">mdi-pencil</v-icon></v-btn>
                    <v-btn class="mr-2" outlined color="green lighten-1" icon="" @click="deleteProduk(item.id)"><v-icon color="green">mdi-trash-can</v-icon></v-btn>
                </template>
            </v-data-table>
        </v-card>
        

        <v-dialog transition="dialog-top-transition" max-width="600" v-model="dialog" style="border-radius: 10px;">
            <v-card>
                <v-card-title>
                    <span class="headline"> Tambah Produk </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                              v-model="p.nama_produk"
                              name="nama_produk"
                              label="Nama Produk"
                              type="text"
                              required
                           ></v-text-field>
                        <v-text-field
                              v-model="p.harga"
                              name="harga"
                              label="harga"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="p.stock"
                              name="stock"
                              label="stock"
                              type="text"
                              required
                           ></v-text-field>
                <!-- </v-card-actions> -->
                </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelEdit"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="store"> Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog transition="dialog-top-transition" max-width="600" v-model="dialogEdit" style="border-radius: 10px;">
            <v-card>
                <v-card-title>
                    <span class="headline"> Edit Produk </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                              v-model="p.nama_produk"
                              name="nama_produk"
                              label="Nama Produk"
                              type="text"
                              required
                           ></v-text-field>
                        <v-text-field
                              v-model="p.harga"
                              name="harga"
                              label="harga"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="p.stock"
                              name="stock"
                              label="stock"
                              type="text"
                              required
                           ></v-text-field>
                <!-- </v-card-actions> -->
                </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelEdit"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="edit(p.id)"> Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

      </v-main>
</template>

<script>
import axios from 'axios'
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue2-helpers/vue-router'

export default {
    data(){
        return{
            dialog: false,
            dialogEdit: false,
            headers: [
                {text: "Nama Produk", value: "nama_produk"},
                {text: "Harga", value: "harga"},
                {text: "Stock", value: "stock"},
                {text: "Actions", value: "actions"},
            ],
            formType: 0,
            form: {
                nama_produk: '',
                harga: '',
                stock: '',
            },
        }
    },
    setup() {
        let user = ref({})
        let produk = ref([])
        const p = reactive({
                nama_produk: '',
                harga: '',
                stock: ''
        });
        const router = useRouter()
        onMounted(() => {
            let id=localStorage.getItem("id_user");
            let token=localStorage.getItem("token");
            axios.get('https://japaeku.com/laravel_kelompokC/public/api/produks', {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                produk.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        })
        function deleteProduk(id) {
            let token=localStorage.getItem("token");
            axios.delete(`https://japaeku.com/laravel_kelompokC/public/api/produks/${id}`, {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                alert("Data berhasil dihapus");
                location.reload();
                produk.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function store(){
            let nama_produk = p.nama_produk
            let harga = p.harga
            let stock = p.stock
            
            let token=localStorage.getItem("token");
            console.log(token);
            axios.post('https://japaeku.com/laravel_kelompokC/public/api/produks',{

                    nama_produk: nama_produk,
                    harga: harga,
                    stock: stock,
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
        function edit(id){
            let nama_produk = p.nama_produk
            let harga = p.harga
            let stock = p.stock
            
            let token=localStorage.getItem("token");
            console.log(token);
            axios.put(`https://japaeku.com/laravel_kelompokC/public/api/produks/${id}`,{

                    nama_produk: nama_produk,
                    harga: harga,
                    stock: stock,
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

        //return
        return { 
            produk,
            deleteProduk,
            p,
            store,
            user,
            edit
        }
    },
    methods:{
        closeDialog() {
            this.dialog = false;
            this.formType = 0;
            this.$refs.form.reset();
        },
        resetForm() {
            this.p = {
                nama_produk: null,
                harga: null,
                stock: null,
            };
        },
        cancelEdit(){
            this.resetForm();
            this.dialog = false;
            this.dialogEdit = false;
        },
        clickEdit(item){
            this.dialogEdit = true;
            this.p.id = item.id;
            this.p.nama_produk = item.nama_produk;
            this.p.harga = item.harga;
            this.p.stock = item.stock;

        },
    }
}

</script>
