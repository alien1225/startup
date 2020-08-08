import Vue from "vue";
import VueRouter from "vue-router";
import MainMap from "./views/main-map";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: "/", component:  MainMap },
    ],
    mode: "history",
});