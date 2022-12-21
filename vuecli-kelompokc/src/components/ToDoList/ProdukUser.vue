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
            </v-row>
        </v-card>
        <v-card elevation="3" style="border-radius: 6px;" class="mt-5 mx-6">
            <v-data-table :headers="headers" :items="produk" :items-per-page="10">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn class="mr-2" outlined color="red lighten-1" icon="" @click="edit(item)"><v-icon color="red">mdi-cart</v-icon></v-btn>
                </template>
            </v-data-table>
        </v-card>

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
        function edit(item){
            let nama_produk = item.nama_produk
            let harga = item.harga
            let stock = item.stock - 1
            
            let token=localStorage.getItem("token");
            console.log(token);
            axios.put(`https://japaeku.com/laravel_kelompokC/public/api/produks/${item.id}`,{

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
            user,
            edit,
            p,
        }
    },
    methods:{
        closeDialog() {
            this.dialog = false;
            this.formType = 0;
            this.$refs.form.reset();
        },
        clickEdit(item){
            this.p.id = item.id;
            this.p.nama_produk = item.nama_produk;
            this.p.harga = item.harga;
            this.p.stock = item.stock-1;
            edit(p.id);
        },
        resetForm() {
            this.pu = {
                nama_produk: null,
                harga: null,
                stock: null,
            };
        },

    }
}

</script>
