import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

function importComponent(path){
    return () => import(`./components/${path}.vue`);
}

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name:"Login",
            component: importComponent("ToDoList/Login"),
        },
        {
            path: "/Register",
            name:"Register",
            component: importComponent("ToDoList/Register"),
        },
        {
            path: "/DashboardLayoutUser",
            name:"user",
            component: importComponent("DashboardLayoutUser"),
            children: [
                
                {
                    path: "/rvu",
                    name: "ReservasiUser",
                    component:importComponent("ToDoList/ReservasiUser"),
                },
                {
                    path: "/DashboardLayoutUser",
                    name: "Profile",
                    component:importComponent("ToDoList/profile"),
                },
                {
                    path: "/pru",
                    name: "ProdukUser",
                    component:importComponent("ToDoList/ProdukUser"),
                },
            
            ]
        },
        {
            path: "/DashboardLayout",
            name:"admin",
            component: importComponent("DashboardLayout"),
            children:[
                {
                    path: "/DashboardLayout",
                    name: "profileAdmin",
                    component:importComponent("ToDoList/profileAdmin"),
                },
                {
                    path: "/rv",
                    name: "Reservasi",
                    component:importComponent("ToDoList/Reservasi"),
                },
                
                {
                    path: "/br",
                    name: "Barber",
                    component:importComponent("ToDoList/Barber"),
                },

                {
                    path: "/p",
                    name: "Produk",
                    component:importComponent("ToDoList/Produk"),
                },
            ],
        },
    ],
});

export default router;