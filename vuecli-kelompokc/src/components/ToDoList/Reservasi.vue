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
                    <v-btn class="font-weight-bold" style="margin:10px auto;font-family: Poppins; font-size: 20px; text-transform: capitalize; float:right; color: #ffff" large color="#ff8600" @click="dialog = true">Add Reservasi</v-btn>
                </v-col>
            </v-row>
        </v-card>
        <v-card elevation="3" style="border-radius: 6px;" class="mt-5 mx-6">
            <v-data-table :headers="headers" :items="reservasi" :items-per-page="10">
                <template v-slot:[`item.status`]="{ item }">{{ item.status ? 'Done' : 'Ongoing' }}</template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn class="mr-2" outlined color="red lighten-1" icon="" @click="dialogEdit = true" disabled v-if="item.status == '1'"><v-icon color="red">mdi-pencil</v-icon></v-btn>
                    <v-btn class="mr-2" outlined color="red lighten-1" icon="" @click="clickEdit(item)" v-else ><v-icon color="green">mdi-pencil</v-icon></v-btn>
                    <v-btn class="mr-2" outlined color="green lighten-1" icon="" @click="deleteReservasi(item.id)"><v-icon color="green">mdi-trash-can</v-icon></v-btn>
                </template>
            </v-data-table>
        </v-card>
        

        <v-dialog transition="dialog-top-transition" max-width="600" v-model="dialog" style="border-radius: 10px;">
            <v-card>
                <v-card-title>
                    <span class="headline"> Tambah Reservasi </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                            v-model="user.nama_user"
                            label="Nama Pelanggan"
                            required
                        ></v-text-field>
                        <v-select
                            v-model="rv.id_barber"
                            :items="barber"
                            item-text="nama_barber"
                            item-value="id"
                            label="Select"
                            persistent-hint
                            return-object
                            single-line
                            ></v-select>
                        <v-text-field
                              v-model="rv.tanggal"
                              name="tanggal"
                              label="tanggal"
                              type="date"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="rv.waktu"
                              name="waktu"
                              label="waktu"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="rv.service"
                              name="service"
                              label="service"
                              type="text"
                              required
                           ></v-text-field>
                           <v-select
                              v-model="rv.status"
                             :items="statuss"
                             item-value="id"
                             item-text="nama"
                              name="status"
                              label="status"
                              type="text"
                              required
                           ></v-select>
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
                    <span class="headline"> Edit Reservasi </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                            v-model="user.nama_user"
                            label="Nama Pelanggan"
                            required
                            disabled
                        ></v-text-field>
                        <v-select
                            v-model="rv.id_barber"
                            :items="barber"
                            item-text="nama_barber"
                            item-value="id"
                            label="Select"
                            persistent-hint
                            return-object
                            single-line
                            required
                            ></v-select>
                        <v-text-field
                              v-model="rv.tanggal"
                              name="tanggal"
                              label="tanggal"
                              type="date"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="rv.waktu"
                              name="waktu"
                              label="waktu"
                              type="text"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="rv.service"
                              name="service"
                              label="service"
                              type="text"
                              required
                           ></v-text-field>
                           <v-select
                              v-model="rv.status"
                             :items="statuss"
                             item-value="id"
                             item-text="nama"
                              name="status"
                              label="status"
                              type="text"
                              required
                           ></v-select>
                <!-- </v-card-actions> -->
                </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelEdit"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="edit(rv.id)"> Save</v-btn>
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
                {text: "Nama Pelanggan", value: "user.nama_user"},
                {text: "Nama Barber", value: "barber.nama_barber"},
                {text: "Tanggal", value: "tanggal"},
                {text: "Waktu", value: "waktu"},
                {text: "Service", value: "service"},
                {text: "Status", value: "status"},
                {text: "Actions", value: "actions"},
            ],
            formType: 0,
            form: {
                id_pelanggan: '',
                id_barber: '',
                tanggal: '',
                waktu: '',
                service: '',
                status: '',
            },
        }
    },
    setup() {
      let statuss = [
         {
            nama: 'Ongoing',
            id: 0
         },
         {
            nama: 'Done',
            id: 1
         }
      ]
        let user = ref({})
        let barber = ref([])
        let reservasi = ref([])
        const rv = reactive({
                id_pelanggan: "",
                id_barber: undefined,
                tanggal: "",
                waktu: "",
                service: "",
                status: ""
        });
        const router = useRouter()
        onMounted(() => {
            let id=localStorage.getItem("id_user");
            let token=localStorage.getItem("token");
            axios.get('https://japaeku.com/laravel_kelompokC/public/api/reservasis', {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                reservasi.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            axios.get('https://japaeku.com/laravel_kelompokC/public/api/barbers', {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                barber.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            axios.get(`https://japaeku.com/laravel_kelompokC/public/api/users/${id}`, {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                user.value = response.data.data
                console.log(`${id}`)
                console.log(response.data.data)
            }).catch(error => {
                console.log(error.response.data)
            })
        })
        function deleteReservasi(id) {
            let token=localStorage.getItem("token");
            axios.delete(`https://japaeku.com/laravel_kelompokC/public/api/reservasis/${id}`, {
                headers: {
                Authorization: `Bearer ${token}`,
                token: token
                }
            })
            .then(response => {
                alert("Data berhasil dihapus");
                location.reload();
                reservasi.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function store(){
            let id_pelanggan = user.value.id
            let id_barber = rv.id_barber.id
            let tanggal = rv.tanggal
            let waktu = rv.waktu
            let service = rv.service
            let status = rv.status
            
            let token=localStorage.getItem("token");
            console.log(token);
            axios.post('https://japaeku.com/laravel_kelompokC/public/api/reservasis',{

                    id_barber: id_barber,
                    id_pelanggan: id_pelanggan,
                    tanggal: tanggal,
                    waktu: waktu,
                    service: service,
                    status: status,
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
            let id_pelanggan = user.value.id
            let id_barber = rv.id_barber.id
            let tanggal = rv.tanggal
            let waktu = rv.waktu
            let service = rv.service
            let status = rv.status
            
            let token=localStorage.getItem("token");
            console.log(token);
            axios.put(`https://japaeku.com/laravel_kelompokC/public/api/reservasis/${id}`,{

                    id_barber: id_barber,
                    id_pelanggan: id_pelanggan,
                    tanggal: tanggal,
                    waktu: waktu,
                    service: service,
                    status: status,
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
            reservasi,
            deleteReservasi,
            status,
            rv,
            store,
            user,
            barber,
            statuss,
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
            this.rv = {
                id_pelanggan: null,
                id_barber: null,
                tanggal: null,
                waktu: null,
                service: null,
                status: null,
            };
        },
        cancelEdit(){
            this.resetForm();
            this.dialog = false;
            this.dialogEdit = false;
        },
        clickEdit(item){
            this.dialogEdit = true;
            this.rv.id = item.id;
            this.rv.id_pelanggan = item.id_pelanggan;
            this.rv.id_barber = item.id_barber;
            this.rv.tanggal = item.tanggal;
            this.rv.waktu = item.waktu;
            this.rv.service = item.service;
            this.rv.status = item.status;

        },
    }
}

</script>
