/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import axios from "axios";
import VueRouter from "vue-router";
import router from "./router";
import Index from "./Index.vue";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = process.env.APP_URL || `//${window.location.host}`;

// Set Vue globally
window.Vue = Vue;

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

// Load Index
Vue.component("index", Index);

const app = new Vue({
    el: "#app",
    router
});
