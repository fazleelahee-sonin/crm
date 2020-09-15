import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth";
import company from "./modules/company";
import employee from "./modules/employee";

Vue.use(Vuex);

export const crmStore = new Vuex.Store({
    modules: {
        auth: auth,
        company: company,
        employee: employee
    }
});
