import Vue from "vue";
import VueRouter from "vue-router";
import Company from "./pages/CompanyComponent.vue";
import Employee from "./pages/EmployeeComponent.vue";
import Login from "./pages/LoginComponent.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Company",
        component: Company
    },
    {
        path: "/",
        name: "Employee",
        component: Employee
    },
    {
        path: "/login",
        name: "login",
        component: Login
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL || `//${window.location.host}`,
    routes
});

export default router;
