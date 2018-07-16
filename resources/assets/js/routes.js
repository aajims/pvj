export default [
    {
        path: '/login',
        name: 'login',
        component: require('./components/views/Login.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/',
        name: 'home',
        component: require('./components/pages/home'),
        meta: {
            auth: true
        }
    },
    {
        path: '/user',
        name: 'user',
        component: require('./components/views/user/User.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/user/create',
        name: 'create.user',
        component: require('./components/views/user/CreateUser'),
        meta: {
            auth: true
        }
    },
    {
        path: '/user/show/:id',
        name: 'show.user',
        component: require('./components/views/user/ShowUser'),
        meta: {
            auth: true
        }
    },
    {
        path: '/user/edit/:id',
        name: 'edit.user',
        component: require('./components/views/user/EditUser'),
        meta: {
            auth: true
        }
    },
    {
        path: '/sms',
        name: 'sms',
        component: require('./components/views/sms.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/profil/edit',
        name: 'edit.profil',
        component: require('./components/views/EditProfil'),
        meta: {
            auth: true
        }
    },
    {
        path: '/profil/password',
        name: 'edit.password',
        component: require('./components/views/EditPassword'),
        meta: {
            auth: true
        }
    },
    {
        path: '/404',
        name: '404',
        component: require('./components/views/PageNotFound.vue'),
        meta: {
            error: true
        }
    },
]
