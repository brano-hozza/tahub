/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import Main from "./components/MainComponent";

require('./bootstrap');

window.Vue = require('vue');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key => {
    let name = key.split('/').pop().split('.')[0];
    name = name.charAt(0).toLowerCase() + name.slice(1)
    name = name.replace(/([a-z0-9]|(?=[A-Z]))([A-Z])/g, '$1-$2').toLowerCase()
    Vue.component(name, files(key).default)
})

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router'
import jdenticon from 'jdenticon';

Vue.use(VueRouter);

import ForOFor from "./components/ForOFor";
import Auth from "./components/Auth";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
import Dashboard from "./components/Dashboard";


import App from './App.vue'
import MainComponent from "./components/MainComponent";
import Messages from "./components/messenger/Messages";
import Messenger from "./components/Messenger";
import Friends from "./components/messenger/Friends";
import Cloud from "./components/Cloud";
import Folder from "./components/cloud/Folder";

const router = new VueRouter({
    routes: [
        {
            path: "/",
            component: MainComponent,
            meta: {
                requiresAuth: true
            },
            children: [
                {
                    path: "/dashboard",
                    component: Dashboard
                },
                {
                    path: "/cloud",
                    component: Cloud,
                    children:[
                        {
                            path:"/cloud",
                            component: Folder
                        }
                    ]
                },
                {
                    path: "/messenger",
                    component: Messenger,
                    children: [
                        {
                            path: "/messenger",
                            component: Messages
                        },
                        {
                            path: "/messenger/friends",
                            component: Friends
                        }
                    ]
                }
            ]

        },
        {
            path:"/auth",
            component: Auth,
            children:[
                {path: "/auth/login", component: Login},
                {path: "/auth/register", component: Register},

            ]
        },
        {
            path: "/*",
            component: ForOFor
        }
    ]
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (to.path === "/"){
            next("/dashboard")
        }
        if (to.path === "/auth"){
            next("/auth/login")
        }
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        var str = window.localStorage;
        var logged_in = str.getItem("logged_in");
        if (logged_in === undefined || !(str.getItem('logged_in') === "true")) {
            next('/auth/login')
        } else {
            next() // go to wherever I'm going
        }
    } else {
        next() // does not require auth, make sure to always call next()!
    }
})

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
