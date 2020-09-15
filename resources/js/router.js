import Vue from "vue";
import VueRouter from "vue-router";
import Company from "./pages/CompanyComponent.vue";
import NewCompany from "./pages/company/NewCompanyComponent.vue";
import EditCompany from "./pages/company/EditCompanyComponent.vue";
import ViewCompany from "./pages/company/ViewCompanyomponent.vue";
import Employee from "./pages/EmployeeComponent.vue";
import AddNewEmployee from "./pages/employee/NewEmployeeComponent.vue";
import EditEmployee from "./pages/employee/EditEmployeeComponent.vue";
import ViewEmployee from "./pages/employee/ViewEmployeeomponent.vue";
import Login from "./pages/LoginComponent.vue";
import NotFoundComponent from "./pages/NotFoundComponent.vue";
import { crmStore } from "./stores/crm-store";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        redirect: {
            name: "login"
        },
        meta: {
            auth: false
        }
    },
    {
        path: "/company",
        name: "company",
        component: Company,
        meta: {
            auth: true
        },
        children: [
            {
                path: "/company/add-new",
                name: "addNewCompany",
                component: NewCompany,
                meta: {
                    auth: true
                },
                props: true
            },

            {
                path: "/company/:id/view",
                name: "viewCompany",
                component: ViewCompany,
                meta: {
                    auth: true
                },
                props: true
            },

            {
                path: "/company/:id/edit",
                name: "editCompany",
                component: EditCompany,
                meta: {
                    auth: true
                },
                props: true
            },
            {
                path: "/company/:companyId/new-employee",
                name: "addNewEmployee",
                component: AddNewEmployee,
                meta: {
                    auth: true
                },
                props: true
            }
        ]
    },
    {
        path: "/employee",
        name: "employee",
        component: Employee,
        meta: {
            auth: true
        },
        children: [
            {
                path: "/employee/:id/edit",
                name: "editEmployee",
                component: EditEmployee,
                meta: {
                    auth: true
                },
                props: true
            },

            {
                path: "/employee/:id/view",
                name: "viewEmployee",
                component: ViewEmployee,
                meta: {
                    auth: true
                },
                props: true
            }
        ]
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: "/*",
        name: "404",
        component: NotFoundComponent
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

//router authguard middleware
router.beforeEach((to, from, next) => {
    if (to.meta.auth) {
        if (to.name !== "login" && !crmStore.state.auth.authenticated)
            next({ name: "login" });
        else next();
    } else if (to.name === "login" && crmStore.state.auth.authenticated) {
        next({ name: "company" });
    } else next();
});
export default router;
