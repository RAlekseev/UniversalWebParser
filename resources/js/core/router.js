import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home'
import Login from './components/Login'
import Registration from './components/Registration'

import usersRouter from '../modules/users/routes'
import parsersRouter from '../modules/parsers/routes'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            children: [...usersRouter, ...parsersRouter],

        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/registration',
            name: 'registration',
            component: Registration,
        },
    ]
});

export default router;
